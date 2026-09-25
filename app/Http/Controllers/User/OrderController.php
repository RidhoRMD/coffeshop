<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Voucher;
use App\Models\DetailPesanan;
use App\Models\Rating;
use App\Services\ProfanityFilter;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function index($kode_qr)
    {
        $meja = Meja::where('kode_qr', $kode_qr)->firstOrFail();

        if ($meja->status === 'nonaktif') {
            abort(404);
        }

        if ($meja->status === 'dipesan' && !$this->customerAdaPesananAktifDiMeja($meja)) {
            return view('order.meja-terisi', compact('meja'));
        }

        $kategori = KategoriMenu::with(['menu' => function ($q) {
            $q->where('status', 'tersedia')
                ->withAvg('ratings', 'bintang')
                ->withCount('ratings');
        }])->get();

        $rekomendasi = Menu::where('status', 'tersedia')
            ->with('kategori')
            ->withSum('detailPesanan as total_terjual', 'qty')
            ->withAvg('ratings', 'bintang')
            ->withCount('ratings')
            ->orderByDesc('total_terjual')
            ->take(3)
            ->get();

        $cart = session($this->cartKey($kode_qr), []);
        $cartItems = [];

        foreach ($cart as $item) {
            $menu = Menu::find($item['menu_id']);

            if ($menu) {
                $cartItems[] = [
                    'id'    => (string) $menu->id,
                    'nama'  => $menu->nama_menu,
                    'harga' => $menu->harga,
                    'qty'   => $item['qty'],
                    'gula'  => $item['gula'] ?? null,
                    'es'    => $item['es'] ?? null,
                ];
            }
        }

        return view('order.index', compact(
            'meja',
            'kategori',
            'cartItems',
            'rekomendasi'
        ));
    }

    protected function cartKey($kodeQr)
    {
        return "cart_meja_{$kodeQr}";
    }

    protected function getCustomerToken()
    {
        return request()->cookie('customer_token');
    }

    protected function customerAdaPesananAktifDiMeja($meja)
    {
        $customerToken = $this->getCustomerToken();

        \Log::info('cek token', [
        'meja' => $meja->nomor_meja,
        'kode_qr' => $meja->kode_qr,
        'cookie_token' => $customerToken,
        'db_token' => $meja->customer_token,
        'match' => $customerToken === $meja->customer_token,
        ]);

        if (!$customerToken) {
            return false;
        }

        return $meja->customer_token === $customerToken;
    }

    public function syncCart(Request $request, $kode_qr)
    {
        $request->validate([
            'items' => 'array',
            'items.*.menu_id' => 'required|exists:menu,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.gula' => 'nullable|string',
            'items.*.es' => 'nullable|string',
        ]);

        session([
            $this->cartKey($kode_qr) => $request->items ?? []
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    protected function hitungTotal($kodeQr)
    {
        $cart = session($this->cartKey($kodeQr), []);
        $total = 0;

        foreach ($cart as $item) {
            $menu = Menu::find($item['menu_id']);

            if ($menu) {
                $total += $menu->harga * $item['qty'];
            }
        }

        return $total;
    }

    protected function hitungTotalSetelahDiskon($kodeQr)
    {
        $total = $this->hitungTotal($kodeQr);

        $voucherSession = session("voucher_{$kodeQr}");

        if ($voucherSession) {
            $voucher = Voucher::find($voucherSession['voucher_id']);

            if ($voucher) {
                $cek = $voucher->isValid($total);

                if ($cek['valid']) {
                    return max(
                        0,
                        $total - $voucher->hitungDiskon($total)
                    );
                }
            }
        }

        return $total;
    }

    public function voucherList($kode_qr)
    {
        $meja = Meja::where('kode_qr', $kode_qr)->firstOrFail();

        $total = $this->hitungTotal($kode_qr);

        $vouchers = Voucher::where('status', 'aktif')
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_expired', '>=', now())
            ->get()
            ->filter(function ($v) {
                return $v->batas_pemakaian == 0 ||
                    $v->jumlah_terpakai < $v->batas_pemakaian;
            });

        $voucherAktifId = session(
            "voucher_{$kode_qr}.voucher_id"
        );

        return view(
            'order.voucher',
            compact(
                'meja',
                'vouchers',
                'total',
                'voucherAktifId'
            )
        );
    }

    public function applyVoucher(Request $request, $kode_qr)
    {
        $request->validate([
            'kode' => 'required|string'
        ]);

        $total = $this->hitungTotal($kode_qr);

        $voucher = Voucher::where(
            'kode',
            $request->kode
        )->first();

        if (!$voucher) {
            return back()->with(
                'error',
                'Voucher tidak ditemukan.'
            );
        }

        $cek = $voucher->isValid($total);

        if (!$cek['valid']) {
            return back()->with(
                'error',
                $cek['message']
            );
        }

        session([
            "voucher_{$kode_qr}" => [
                'voucher_id' => $voucher->id,
                'kode' => $voucher->kode,
            ]
        ]);

        return redirect()
            ->route(
                'order.checkout.page',
                $kode_qr
            )
            ->with(
                'success',
                'Voucher berhasil diterapkan.'
            );
    }

    public function removeVoucher($kode_qr)
    {
        session()->forget(
            "voucher_{$kode_qr}"
        );

        return redirect()
            ->route(
                'order.checkout.page',
                $kode_qr
            )
            ->with(
                'success',
                'Voucher dibatalkan.'
            );
    }

    public function generateQris(Request $request, $kode_qr)
    {
        $total = $this->hitungTotalSetelahDiskon($kode_qr);

        if ($total <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang masih kosong.'
            ], 422);
        }

        $orderId =
            'CS-QR-' .
            strtoupper(Str::random(8));

        $midtrans = new MidtransService();

        $result = $midtrans->chargeQris(
            $orderId,
            $total
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
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
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
        }

        return response()->json([
            'success' => true,
            'transaction_status' =>
                $result['data']->transaction_status,
        ]);
    }

    public function checkout(
        Request $request,
        $kode_qr
    ) {
        $request->validate([
            'nama_customer' =>
                'nullable|string|max:255',

            'qris_order_id' =>
                'required|string',
        ]);

        $meja = Meja::where(
            'kode_qr',
            $kode_qr
        )->firstOrFail();

        if (
            $meja->status === 'dipesan' &&
            !$this->customerAdaPesananAktifDiMeja($meja)
        ) {
            return redirect()
                ->route(
                    'order.index',
                    $kode_qr
                );
        }

        $cart = session(
            $this->cartKey($kode_qr),
            []
        );

        if (empty($cart)) {
            return back()->with(
                'error',
                'Keranjang masih kosong.'
            );
        }

        $midtrans = new MidtransService();

        $result = $midtrans->checkStatus(
            $request->qris_order_id
        );

        if (
            !$result['success'] ||
            !in_array(
                $result['data']->transaction_status,
                ['settlement', 'capture']
            )
        ) {
            return back()->with(
                'error',
                'Pembayaran belum terkonfirmasi lunas.'
            );
        }

        $total = 0;
        $detailData = [];

        foreach ($cart as $item) {
            $menu = Menu::findOrFail(
                $item['menu_id']
            );

            $subtotal =
                $menu->harga * $item['qty'];

            $total += $subtotal;

            $detailData[] = [
                'menu_id' =>
                    $menu->id,

                'qty' =>
                    $item['qty'],

                'harga' =>
                    $menu->harga,

                'subtotal' =>
                    $subtotal,

                'level_gula' =>
                    $item['gula'] ?? null,

                'level_es' =>
                    $item['es'] ?? null,
            ];
        }

        $voucher = null;
        $diskon = 0;

        $voucherSession =
            session("voucher_{$kode_qr}");

        if ($voucherSession) {
            $voucherCandidate =
                Voucher::find(
                    $voucherSession['voucher_id']
                );

            if ($voucherCandidate) {
                $cek =
                    $voucherCandidate->isValid($total);

                if ($cek['valid']) {
                    $voucher =
                        $voucherCandidate;

                    $diskon =
                        $voucher->hitungDiskon(
                            $total
                        );
                }
            }
        }

        $totalAkhir =
            max(0, $total - $diskon);

        $kodePesanan =
            'CS-' .
            strtoupper(Str::random(6));

        $pesanan = Pesanan::create([
            'kode_pesanan' =>
                $kodePesanan,

            'jenis_pesanan' =>
                'dine_in_qr',

            'meja_id' =>
                $meja->id,

            'nama_customer' =>
                $request->nama_customer,

            'voucher_id' =>
                $voucher?->id,

            'diskon' =>
                $diskon,

            'total' =>
                $totalAkhir,

            'status_pesanan' =>
                'baru',

            'status_pembayaran' =>
                'berhasil',
        ]);

        foreach ($detailData as $detail) {
            $pesanan
                ->detailPesanan()
                ->create($detail);

            $menu =
                Menu::find(
                    $detail['menu_id']
                );

            $stokBaru =
                max(
                    0,
                    $menu->stok -
                    $detail['qty']
                );

            $menu->update([
                'stok' =>
                    $stokBaru,

                'status' =>
                    $stokBaru <= 0
                        ? 'habis'
                        : $menu->status,
            ]);
        }

        if ($voucher) {
            $voucher->increment(
                'jumlah_terpakai'
            );
        }

        $pesanan->pembayaran()->create([
            'metode' =>
                'QRIS',

            'order_id' =>
                $request->qris_order_id,

            'status_pembayaran' =>
                'lunas',

            'waktu_bayar' =>
                now(),
        ]);

        /*
         * Ambil token browser customer.
         * Kalau belum punya, buat token baru.
         */
        $customerToken =
            $this->getCustomerToken();

        if (!$customerToken) {
            $customerToken =
                Str::random(64);
        }

        /*
         * Simpan pemilik meja.
         */
        $meja->update([
            'status' =>
                'dipesan',

            'customer_token' =>
                $customerToken,
        ]);

        $riwayat =
            session(
                "riwayat_pesanan_{$kode_qr}",
                []
            );

        $riwayat[] =
            $kodePesanan;

        session([
            "riwayat_pesanan_{$kode_qr}" =>
                $riwayat
        ]);

        session()->forget(
            $this->cartKey($kode_qr)
        );

        session()->forget(
            "voucher_{$kode_qr}"
        );

        // Simpan cookie ke browser
    Cookie::queue(
        'customer_token',
        $customerToken,
        60 * 24 * 30
    );

    return redirect()->route('order.sukses', $kodePesanan);
    }

    public function sukses($kode)
    {
        $pesanan =
            Pesanan::with([
                'meja',
                'detailPesanan.menu'
            ])
            ->where(
                'kode_pesanan',
                $kode
            )
            ->firstOrFail();

        return view(
            'order.sukses',
            compact('pesanan')
        );
    }

    public function checkoutPage($kode_qr)
    {
        $meja =
            Meja::where(
                'kode_qr',
                $kode_qr
            )->firstOrFail();

        if (
            $meja->status === 'dipesan' &&
            !$this->customerAdaPesananAktifDiMeja($meja)
        ) {
            return view(
                'order.meja-terisi',
                compact('meja')
            );
        }

        $cart =
            session(
                $this->cartKey($kode_qr),
                []
            );

        if (empty($cart)) {
            return redirect()
                ->route(
                    'order.index',
                    $kode_qr
                )
                ->with(
                    'error',
                    'Keranjang masih kosong.'
                );
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $item) {
            $menu =
                Menu::find(
                    $item['menu_id']
                );

            if ($menu) {
                $subtotal =
                    $menu->harga *
                    $item['qty'];

                $total += $subtotal;

                $cartItems[] = [
                    'nama' =>
                        $menu->nama_menu,

                    'harga' =>
                        $menu->harga,

                    'qty' =>
                        $item['qty'],

                    'gula' =>
                        $item['gula'] ?? null,

                    'es' =>
                        $item['es'] ?? null,

                    'subtotal' =>
                        $subtotal,
                ];
            }
        }

        $voucher = null;
        $diskon = 0;

        $voucherSession =
            session("voucher_{$kode_qr}");

        if ($voucherSession) {
            $voucher =
                Voucher::find(
                    $voucherSession['voucher_id']
                );

            if ($voucher) {
                $cek =
                    $voucher->isValid($total);

                if (!$cek['valid']) {
                    session()->forget(
                        "voucher_{$kode_qr}"
                    );

                    $voucher = null;
                } else {
                    $diskon =
                        $voucher->hitungDiskon(
                            $total
                        );
                }
            } else {
                session()->forget(
                    "voucher_{$kode_qr}"
                );
            }
        }

        $totalAkhir =
            max(0, $total - $diskon);

        return view(
            'order.checkout',
            compact(
                'meja',
                'cartItems',
                'total',
                'voucher',
                'diskon',
                'totalAkhir'
            )
        );
    }

    public function pesananSaya($kode_qr)
    {
        $meja =
            Meja::where(
                'kode_qr',
                $kode_qr
            )->firstOrFail();

        $daftarKode =
            session(
                "riwayat_pesanan_{$kode_qr}",
                []
            );

        $pesananSaya =
            Pesanan::with(
                'detailPesanan.menu'
            )
            ->whereIn(
                'kode_pesanan',
                $daftarKode
            )
            ->where(
                'status_pesanan',
                '!=',
                'selesai'
            )
            ->latest()
            ->get();

        return view(
            'order.pesanan',
            compact(
                'meja',
                'pesananSaya'
            )
        );
    }

    public function riwayatSaya($kode_qr)
    {
        $meja =
            Meja::where(
                'kode_qr',
                $kode_qr
            )->firstOrFail();

        $daftarKode =
            session(
                "riwayat_pesanan_{$kode_qr}",
                []
            );

        $riwayatSaya =
            Pesanan::with([
                'detailPesanan.menu',
                'detailPesanan.rating'
            ])
            ->whereIn(
                'kode_pesanan',
                $daftarKode
            )
            ->where(
                'status_pesanan',
                'selesai'
            )
            ->latest()
            ->get();

        return view(
            'order.riwayat',
            compact(
                'meja',
                'riwayatSaya'
            )
        );
    }

    public function submitRating(
        Request $request,
        $kode_qr
    ) {
        $request->validate([
            'detail_pesanan_id' =>
                'required|exists:detail_pesanan,id',

            'bintang' =>
                'required|integer|min:1|max:5',

            'komentar' =>
                'nullable|string|max:500',
        ]);

        $daftarKode =
            session(
                "riwayat_pesanan_{$kode_qr}",
                []
            );

        $detail =
            DetailPesanan::with('pesanan')
            ->findOrFail(
                $request->detail_pesanan_id
            );

        if (
            !in_array(
                $detail->pesanan->kode_pesanan,
                $daftarKode
            )
        ) {
            abort(403);
        }

        if (
            $detail->pesanan->status_pesanan
            !== 'selesai'
        ) {
            return back()->with(
                'error',
                'Pesanan belum selesai, belum bisa diberi rating.'
            );
        }

        if (
            Rating::where(
                'detail_pesanan_id',
                $detail->id
            )->exists()
        ) {
            return back()->with(
                'error',
                'Menu ini sudah pernah diberi rating.'
            );
        }

        if (
            $request->filled('komentar') &&
            ProfanityFilter::containsBadWord(
                $request->komentar
            )
        ) {
            return back()->with(
                'error',
                'Pesan ini mengandung kata yang tidak pantas.'
            );
        }

        Rating::create([
            'detail_pesanan_id' =>
                $detail->id,

            'menu_id' =>
                $detail->menu_id,

            'bintang' =>
                $request->bintang,

            'komentar' =>
                $request->komentar,
        ]);

        return back()->with(
            'success',
            'Terima kasih atas rating kamu!'
        );
    }
}