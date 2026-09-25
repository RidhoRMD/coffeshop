<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Pembayaran;
use App\Models\DetailPesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $dariTanggal = $request->dari_tanggal ?? now()->format('Y-m-d');
        $sampaiTanggal = $request->sampai_tanggal ?? now()->format('Y-m-d');

        $pesanan = Pesanan::with(['meja', 'shift.kasir', 'barista',])
            ->whereDate('created_at', '>=', $dariTanggal)
            ->whereDate('created_at', '<=', $sampaiTanggal)
            ->latest()
            ->get();

        return view('dashboard.admin.pesanan.index', compact('pesanan', 'dariTanggal', 'sampaiTanggal'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with([
            'meja',
            'detailPesanan.menu',
            'shift.kasir',
            'barista',
        ])->findOrFail($id);

        return view('dashboard.admin.pesanan.show', compact('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pesanan->update([
            'status_pesanan' => $request->status_pesanan,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function dashboard()
    {
        $totalMenu = Menu::count();
        $totalMeja = Meja::count();
        $totalPesanan = Pesanan::count();

        $totalPendapatan = Pesanan::where('status_pembayaran', 'berhasil')->sum('total');

        $pesananTerbaru = Pesanan::with('meja')->latest()->take(5)->get();

        $statusMenunggu = Pesanan::where('status_pembayaran', 'menunggu')->count();
        $statusBerhasil = Pesanan::where('status_pembayaran', 'berhasil')->count();
        $statusDibatalkan = Pesanan::where('status_pembayaran', 'dibatalkan')->count();

        return view('dashboard.admin.index', compact(
            'totalMenu',
            'totalMeja',
            'totalPesanan',
            'totalPendapatan',
            'pesananTerbaru',
            'statusMenunggu',
            'statusBerhasil',
            'statusDibatalkan'
        ));
    }

    public function destroy(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $kode = $pesanan->kode_pesanan;

        $pesanan->delete();

        $urlKembali = $request->headers->get('referer') ?? route('admin.pesanan.index');

        return redirect($urlKembali)
            ->with('success', "Pesanan {$kode} berhasil dihapus.");
    }

    private function hitungLaporan($dariTanggal, $sampaiTanggal)
    {
        $query = Pesanan::where('status_pembayaran', 'berhasil')
            ->whereDate('created_at', '>=', $dariTanggal)
            ->whereDate('created_at', '<=', $sampaiTanggal);

        $totalTransaksi = (clone $query)->count();
        $totalPendapatan = (clone $query)->sum('total');
        $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        $transaksi = (clone $query)->with('meja')->latest()->get();

        $metodeBayar = Pembayaran::select('metode', DB::raw('count(*) as jumlah'), DB::raw('sum(pesanan.total) as total'))
            ->join('pesanan', 'pembayaran.pesanan_id', '=', 'pesanan.id')
            ->where('pesanan.status_pembayaran', 'berhasil')
            ->whereDate('pesanan.created_at', '>=', $dariTanggal)
            ->whereDate('pesanan.created_at', '<=', $sampaiTanggal)
            ->groupBy('metode')
            ->get();

        $jenisPesanan = (clone $query)
            ->select('jenis_pesanan', DB::raw('count(*) as jumlah'))
            ->groupBy('jenis_pesanan')
            ->get();

        $menuTerlaris = DetailPesanan::select('menu_id', DB::raw('sum(qty) as total_qty'))
            ->whereHas('pesanan', function ($q) use ($dariTanggal, $sampaiTanggal) {
                $q->where('status_pembayaran', 'berhasil')
                    ->whereDate('created_at', '>=', $dariTanggal)
                    ->whereDate('created_at', '<=', $sampaiTanggal);
            })
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('menu')
            ->get();

            $perKasir = Pesanan::select('shift.kasir_id', DB::raw('count(*) as jumlah'), DB::raw('sum(pesanan.total) as total'))
            ->join('shift', 'pesanan.shift_id', '=', 'shift.id')
            ->with('shift.kasir')
            ->where('pesanan.status_pembayaran', 'berhasil')
            ->whereDate('pesanan.created_at', '>=', $dariTanggal)
            ->whereDate('pesanan.created_at', '<=', $sampaiTanggal)
            ->groupBy('shift.kasir_id')
            ->get()
            ->map(function ($item) {
                $kasir = \App\Models\User::find($item->kasir_id);
                return [
                    'nama'   => $kasir->name ?? 'Tidak diketahui',
                    'jumlah' => $item->jumlah,
                    'total'  => $item->total,
                ];
            });

        return compact(
            'totalTransaksi', 'totalPendapatan', 'rataRata', 'transaksi',
            'metodeBayar', 'jenisPesanan', 'menuTerlaris', 'perKasir'
        );
    }

    public function laporan(Request $request)
    {
        $dariTanggal = $request->dari_tanggal ?? now()->startOfMonth()->format('Y-m-d');
        $sampaiTanggal = $request->sampai_tanggal ?? now()->format('Y-m-d');

        $data = $this->hitungLaporan($dariTanggal, $sampaiTanggal);

        return view('dashboard.admin.laporan', array_merge(
            compact('dariTanggal', 'sampaiTanggal'),
            $data
        ));
    }

    public function laporanPdf(Request $request)
    {
        $dariTanggal = $request->dari_tanggal ?? now()->startOfMonth()->format('Y-m-d');
        $sampaiTanggal = $request->sampai_tanggal ?? now()->format('Y-m-d');

        $data = $this->hitungLaporan($dariTanggal, $sampaiTanggal);

        $pdf = Pdf::loadView('dashboard.admin.laporan-pdf', array_merge(
            compact('dariTanggal', 'sampaiTanggal'),
            $data
        ));

        return $pdf->download('laporan-penjualan-' . $dariTanggal . '-sampai-' . $sampaiTanggal . '.pdf');
    }
}