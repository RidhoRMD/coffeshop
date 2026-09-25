<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Voucher;

class PesananController extends Controller
{
    public function index()
    {
        $shiftAktif = $this->getShiftAktif();
        $awalHari = $this->awalHariOperasional();

        // Ambil ID pesanan terakhir per meja, supaya status meja "belum kosong"
        // cuma dianggap terkait dengan pesanan TERBARU di meja itu, bukan histori lama
        $latestPerMejaIds = Pesanan::whereNotNull('meja_id')
            ->selectRaw('MAX(id) as id')
            ->groupBy('meja_id')
            ->pluck('id');

        $pesanan = Pesanan::with('meja')
            ->where(function ($q) use ($shiftAktif, $latestPerMejaIds, $awalHari) {
                $q->where('shift_id', $shiftAktif->id)
                ->where('created_at', '>=', $awalHari)
                ->orWhere(function ($q2) use ($latestPerMejaIds) {
                    // Carry-over dari shift yang sudah tutup: hanya pesanan TERBARU
                    // di meja itu yang dianggap masih "menunggu dikosongkan".
                    // Ini SENGAJA tidak dibatasi jam 3 pagi — kalau mejanya belum
                    // dikosongkan, kasir tetap perlu lihat itu walau lintas hari.
                    $q2->whereIn('id', $latestPerMejaIds)
                        ->whereHas('meja', function ($q2b) {
                            $q2b->where('status', '!=', 'kosong');
                        })
                        ->whereHas('shift', function ($q3) {
                            $q3->where('status', 'tutup');
                        });
                })
                ->orWhere(function ($q4) use ($latestPerMejaIds, $awalHari) {
                    // Pesanan dari Customer scan QR (belum diklaim shift manapun)
                    $q4->whereNull('shift_id')
                        ->where(function ($q4a) use ($latestPerMejaIds, $awalHari) {
                            $q4a->where('created_at', '>=', $awalHari)
                                ->orWhere(function ($q4c) use ($latestPerMejaIds) {
                                    $q4c->whereIn('id', $latestPerMejaIds)
                                        ->whereHas('meja', function ($q4b) {
                                            $q4b->where('status', '!=', 'kosong');
                                        });
                                });
                        });
                });
            })
            ->latest()
            ->get();

        return view('dashboard.kasir.pesanan.index', compact('pesanan'));
    }

     public function create()
    {
        return view('dashboard.kasir.pesanan.create');
    }

    public function createDineIn()
    {
        $meja = Meja::where('status', 'kosong')->get();
        $kategori = KategoriMenu::with(['menu' => function ($q) {
            $q->where('status', 'tersedia');
        }])->get();

        return view('dashboard.kasir.pesanan.create-dinein', compact('meja', 'kategori'));
    }

    public function createTakeAway()
    {
        $kategori = KategoriMenu::with(['menu' => function ($q) {
            $q->where('status', 'tersedia');
        }])->get();

        return view('dashboard.kasir.pesanan.create-takeaway', compact('kategori'));
    }

    public function storeDineIn(Request $request)
    {
        $request->validate([
            'meja_id' => 'required|exists:meja,id',
            'nama_customer' => 'nullable|string|max:255',
            'metode' => 'required|in:tunai,qris',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menu,id',
            'items.*.qty' => 'required|integer|min:1|max:100',
            'items.*.level_gula' => 'nullable|string|max:20',
            'items.*.level_es' => 'nullable|string|max:20',
            'uang_dibayar' => 'nullable|string',
            'qris_order_id' => 'required_if:metode,qris|nullable|string',
            'voucher_id' => 'nullable|exists:voucher,id',
        ]);

        // Gabungkan qty per menu_id dulu (satu menu bisa muncul di beberapa baris
        // kalau varian gula/es-nya beda), lalu cek stoknya SEBELUM apa pun disimpan.
        $qtyPerMenu = [];
        foreach ($request->items as $item) {
            $qtyPerMenu[$item['menu_id']] = ($qtyPerMenu[$item['menu_id']] ?? 0) + $item['qty'];
        }

        foreach ($qtyPerMenu as $menuId => $qtyDiminta) {
            $menu = Menu::findOrFail($menuId);
            if ($qtyDiminta > $menu->stok) {
                return back()
                    ->withInput()
                    ->with('error', "Stok {$menu->nama_menu} tidak mencukupi. Tersisa {$menu->stok}, kamu memesan {$qtyDiminta}.");
            }
        }

        $total = 0;
        $detailData = [];

        foreach ($request->items as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            $subtotal = $menu->harga * $item['qty'];
            $total += $subtotal;

            $detailData[] = [
                'menu_id'    => $menu->id,
                'qty'        => $item['qty'],
                'harga'      => $menu->harga,
                'subtotal'   => $subtotal,
                'level_gula' => $item['level_gula'] ?? null,
                'level_es'   => $item['level_es'] ?? null,
            ];
        }

               $voucher = null;
        $diskon = 0;

        if ($request->filled('voucher_id')) {
            $voucherCandidate = Voucher::find($request->voucher_id);
            if ($voucherCandidate) {
                $cekVoucher = $voucherCandidate->isValid($total);
                if ($cekVoucher['valid']) {
                    $voucher = $voucherCandidate;
                    $diskon = $voucher->hitungDiskon($total);
                }
            }
        }

        $totalAkhir = max(0, $total - $diskon);

        // Bersihin format titik ribuan dari uang_dibayar sebelum diproses
        $uangDibayar = (int) str_replace('.', '', $request->uang_dibayar ?? '0');

        if ($request->metode === 'tunai') {
            if ($uangDibayar < $totalAkhir) {
                return back()
                    ->withInput()
                    ->with('error', 'Uang yang dibayarkan kurang dari total pesanan.');
            }
        }

        if ($request->metode === 'qris') {
            $midtrans = new MidtransService();
            $result = $midtrans->checkStatus($request->qris_order_id);

            if (!$result['success'] || !in_array($result['data']->transaction_status, ['settlement', 'capture'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Pembayaran QRIS belum terkonfirmasi lunas. Coba lagi.');
            }
        }

        $kodePesanan = 'CS-' . strtoupper(Str::random(6));

                $pesanan = Pesanan::create([
            'shift_id'           => $this->getShiftAktif()->id,
            'kode_pesanan'       => $kodePesanan,
            'jenis_pesanan'      => 'dine_in',
            'meja_id'            => $request->meja_id,
            'nama_customer'      => $request->nama_customer,
            'voucher_id'         => $voucher?->id,
            'diskon'             => $diskon,
            'total'              => $totalAkhir,
            'status_pesanan'     => 'baru',
            'status_pembayaran'  => 'berhasil',
        ]);

        foreach ($detailData as $detail) {
            $pesanan->detailPesanan()->create($detail);

            $menu = Menu::find($detail['menu_id']);
            $stokBaru = max(0, $menu->stok - $detail['qty']);

            $menu->update([
                'stok'   => $stokBaru,
                'status' => $stokBaru <= 0 ? 'habis' : $menu->status,
            ]);
        }

        if ($voucher) {
            $voucher->increment('jumlah_terpakai');
        }

        $pesanan->pembayaran()->create([
            'metode'             => $request->metode === 'tunai' ? 'tunai' : 'QRIS',
            'order_id'           => $request->metode === 'qris' ? $request->qris_order_id : $kodePesanan,
            'status_pembayaran'  => 'lunas',
            'waktu_bayar'        => now(),
        ]);

        $pesanan->meja()->update([
            'status' => 'dipesan',
            'customer_token' => null,
        ]);

        return redirect()
            ->route('kasir.pesanan.show', $pesanan->id)
            ->with('success', 'Pesanan berhasil dibuat, pembayaran lunas.');
    }

    public function bayar($id)
    {
        $pesanan = Pesanan::with(['meja', 'detailPesanan.menu'])->findOrFail($id);

        if ($pesanan->status_pembayaran !== 'menunggu') {
            return redirect()
                ->route('kasir.pesanan.show', $pesanan->id)
                ->with('error', 'Pesanan ini sudah diproses pembayarannya.');
        }

        return view('dashboard.kasir.pesanan.bayar', compact('pesanan'));
    }

    public function prosesBayar(Request $request, $id)
    {
        $request->validate([
            'metode' => 'required|in:QRIS,tunai',
            'uang_dibayar' => 'nullable|integer|min:0',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status_pembayaran !== 'menunggu') {
            return redirect()
                ->route('kasir.pesanan.show', $pesanan->id)
                ->with('error', 'Pesanan ini sudah diproses pembayarannya.');
        }

        if ($request->metode === 'tunai' && $request->uang_dibayar < $pesanan->total) {
            return back()->with('error', 'Uang yang dibayarkan kurang dari total pesanan.');
        }

        $pesanan->pembayaran()->updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'metode'             => $request->metode,
                'order_id'           => $pesanan->kode_pesanan,
                'status_pembayaran'  => 'lunas',
                'waktu_bayar'        => now(),
            ]
        );

        $pesanan->update(['status_pembayaran' => 'berhasil']);

        return redirect()
            ->route('kasir.pesanan.show', $pesanan->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function storeTakeAway(Request $request)
    {
        $request->validate([
            'nama_customer' => 'nullable|string|max:255',
            'metode' => 'required|in:tunai,qris',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menu,id',
            'items.*.qty' => 'required|integer|min:1|max:100',
            'items.*.level_gula' => 'nullable|string|max:20',
            'items.*.level_es' => 'nullable|string|max:20',
            'uang_dibayar' => 'required_if:metode,tunai|nullable|integer|min:0',
            'qris_order_id' => 'required_if:metode,qris|nullable|string',
            'voucher_id' => 'nullable|exists:voucher,id',
        ]);

        // Gabungkan qty per menu_id dulu, lalu cek stoknya SEBELUM apa pun disimpan.
        $qtyPerMenu = [];
        foreach ($request->items as $item) {
            $qtyPerMenu[$item['menu_id']] = ($qtyPerMenu[$item['menu_id']] ?? 0) + $item['qty'];
        }

        foreach ($qtyPerMenu as $menuId => $qtyDiminta) {
            $menu = Menu::findOrFail($menuId);
            if ($qtyDiminta > $menu->stok) {
                return back()
                    ->withInput()
                    ->with('error', "Stok {$menu->nama_menu} tidak mencukupi. Tersisa {$menu->stok}, kamu memesan {$qtyDiminta}.");
            }
        }

        $total = 0;
        $detailData = [];

        foreach ($request->items as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            $subtotal = $menu->harga * $item['qty'];
            $total += $subtotal;

            $detailData[] = [
                'menu_id'    => $menu->id,
                'qty'        => $item['qty'],
                'harga'      => $menu->harga,
                'subtotal'   => $subtotal,
                'level_gula' => $item['level_gula'] ?? null,
                'level_es'   => $item['level_es'] ?? null,
            ];
        }

                $voucher = null;
        $diskon = 0;

        if ($request->filled('voucher_id')) {
            $voucherCandidate = Voucher::find($request->voucher_id);
            if ($voucherCandidate) {
                $cekVoucher = $voucherCandidate->isValid($total);
                if ($cekVoucher['valid']) {
                    $voucher = $voucherCandidate;
                    $diskon = $voucher->hitungDiskon($total);
                }
            }
        }

        $totalAkhir = max(0, $total - $diskon);

        // Validasi ulang pembayaran di server
        if ($request->metode === 'tunai') {
            if ($request->uang_dibayar < $totalAkhir) {
                return back()
                    ->withInput()
                    ->with('error', 'Uang yang dibayarkan kurang dari total pesanan.');
            }
        }

        if ($request->metode === 'qris') {
            $midtrans = new MidtransService();
            $result = $midtrans->checkStatus($request->qris_order_id);

            if (!$result['success'] || !in_array($result['data']->transaction_status, ['settlement', 'capture'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Pembayaran QRIS belum terkonfirmasi lunas. Coba lagi.');
            }
        }

        $kodePesanan = 'CS-' . strtoupper(Str::random(6));

        $pesanan = Pesanan::create([
            'shift_id'           => $this->getShiftAktif()->id,
            'kode_pesanan'       => $kodePesanan,
            'jenis_pesanan'      => 'takeaway',
            'nama_customer'      => $request->nama_customer,
            'voucher_id'         => $voucher?->id,
            'diskon'             => $diskon,
            'total'              => $totalAkhir,
            'status_pesanan'     => 'baru',
            'status_pembayaran'  => 'berhasil',
        ]);

        foreach ($detailData as $detail) {
            $pesanan->detailPesanan()->create($detail);

            $menu = Menu::find($detail['menu_id']);
            $stokBaru = max(0, $menu->stok - $detail['qty']);

            $menu->update([
                'stok'   => $stokBaru,
                'status' => $stokBaru <= 0 ? 'habis' : $menu->status,
            ]);
        }

        if ($voucher) {
            $voucher->increment('jumlah_terpakai');
        }

        $pesanan->pembayaran()->create([
            'metode'             => $request->metode === 'tunai' ? 'tunai' : 'QRIS',
            'order_id'           => $request->metode === 'qris' ? $request->qris_order_id : $kodePesanan,
            'status_pembayaran'  => 'lunas',
            'waktu_bayar'        => now(),
        ]);

        return redirect()
            ->route('kasir.pesanan.show', $pesanan->id)
            ->with('success', 'Pesanan Take Away berhasil dibuat, pembayaran lunas.');
    }

    public function show($id)
    {
        $pesanan = Pesanan::with([
            'meja',
            'detailPesanan.menu',
            'pembayaran',
        ])->findOrFail($id);
        $isPesananAktifDiMeja = false;

        if ($pesanan->meja_id) {
            $latestIdUntukMeja = Pesanan::where('meja_id', $pesanan->meja_id)->max('id');
            $isPesananAktifDiMeja = ($latestIdUntukMeja == $pesanan->id);
        }

        return view('dashboard.kasir.pesanan.show', compact('pesanan', 'isPesananAktifDiMeja'));
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status_pesanan !== 'baru' || $pesanan->status_pembayaran !== 'menunggu') {
            return redirect()
                ->route('kasir.pesanan.index')
                ->with('error', 'Pesanan tidak bisa dihapus karena sudah diproses.');
        }

        // Kembalikan meja jadi kosong lagi kalau dine in
        if ($pesanan->meja_id) {
            $pesanan->meja()->update([
                'status' => 'kosong',
                'customer_token' => null,
            ]);
        }

        $pesanan->detailPesanan()->delete();
        $pesanan->delete();

        return redirect()
            ->route('kasir.pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    public function generateQris(Request $request)
    {
        $request->validate([
            'total' => 'required|integer|min:1',
        ]);

        $orderId = 'CS-QR-' . strtoupper(Str::random(8));

        $midtrans = new MidtransService();
        $result = $midtrans->chargeQris($orderId, $request->total);

        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message']], 500);
        }

        return response()->json([
            'success' => true,
            'order_id' => $orderId,
            'qr_url' => $result['qr_url'],
        ]);
    }

    public function statusQris($orderId)
    {
        $midtrans = new MidtransService();
        $result = $midtrans->checkStatus($orderId);

        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message']], 500);
        }

        return response()->json([
            'success' => true,
            'transaction_status' => $result['data']->transaction_status,
        ]);
    }

        public function kosongkanMeja($id)
    {
        $pesanan = Pesanan::with('meja')->findOrFail($id);

        if (!$pesanan->meja) {
            return redirect()
                ->route('kasir.pesanan.show', $pesanan->id)
                ->with('error', 'Pesanan ini tidak terkait dengan meja manapun.');
        }

        $pesanan->meja->update([
            'status' => 'kosong',
            'customer_token' => null,
        ]);

        // Kalau ini pesanan dari Customer QR (belum ada shift_id), catat sebagai
        // ditangani oleh kasir yang barusan mengosongkan mejanya
        if (is_null($pesanan->shift_id)) {
            $pesanan->update(['shift_id' => $this->getShiftAktif()->id]);
        }

        return redirect()
            ->route('kasir.pesanan.show', $pesanan->id)
            ->with('success', 'Meja ' . $pesanan->meja->nomor_meja . ' berhasil dikosongkan.');
    }

    public function resi($id)
    {
        $pesanan = Pesanan::with(['meja', 'detailPesanan.menu', 'pembayaran'])->findOrFail($id);

        return view('dashboard.kasir.pesanan.resi', compact('pesanan'));
    }

    public function dashboard()
    {
        $shiftAktif = $this->getShiftAktif();
        $awalHari = $this->awalHariOperasional();

        // Dibatasi shift aktif DAN jam operasional hari ini (mulai jam 3 pagi),
        // supaya kalau shift kebuka lintas hari, pesanan "kemarin" gak ikut
        // kehitung sebagai "hari ini" lagi.
        $pesananShift = Pesanan::where(function ($q) use ($shiftAktif) {
        $q->where('shift_id', $shiftAktif->id)
          ->orWhereNull('shift_id');
        })
        ->where('created_at', '>=', $awalHari);

        $pesananHariIni = (clone $pesananShift)->count();

        $menungguPembayaran = (clone $pesananShift)->where('status_pembayaran', 'menunggu')->count();

        $pendapatanHariIni = (clone $pesananShift)
            ->where('status_pembayaran', 'berhasil')
            ->sum('total');

        $mejaTerisi = Meja::where('status', 'dipesan')->count();
        $totalMeja = Meja::count();

        $pesananTerbaru = (clone $pesananShift)->with('meja')->latest()->take(5)->get();

        return view('dashboard.kasir.index', compact(
            'pesananHariIni',
            'menungguPembayaran',
            'pendapatanHariIni',
            'mejaTerisi',
            'totalMeja',
            'pesananTerbaru'
        ));
    }

        public function cekVoucher(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
            'total' => 'required|integer|min:0',
        ]);

        $voucher = Voucher::where('kode', $request->kode)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Voucher tidak ditemukan.']);
        }

        $cek = $voucher->isValid($request->total);

        if (!$cek['valid']) {
            return response()->json(['success' => false, 'message' => $cek['message']]);
        }

        $diskon = $voucher->hitungDiskon($request->total);

        return response()->json([
            'success'     => true,
            'voucher_id'  => $voucher->id,
            'kode'        => $voucher->kode,
            'diskon'      => $diskon,
            'total_akhir' => max(0, $request->total - $diskon),
        ]);
    }

    private function getShiftAktif()
    {
        return \App\Models\Shift::where('kasir_id', Auth::id())
            ->where('status', 'buka')
            ->firstOrFail();
    }

    /**
     * Titik awal "hari operasional" toko: jam 3 pagi.
     * Kalau sekarang masih sebelum jam 3 pagi, hari operasional
     * dianggap masih mulai dari jam 3 pagi KEMARIN.
     */
    private function awalHariOperasional()
    {
        return now()->hour < 3
            ? now()->subDay()->setTime(3, 0, 0)
            : now()->setTime(3, 0, 0);
    }
}