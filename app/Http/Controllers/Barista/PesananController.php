<?php

namespace App\Http\Controllers\Barista;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['meja', 'detailPesanan.menu'])
            ->where('status_pembayaran', 'berhasil')
            ->where('status_pesanan', '!=', 'selesai')
            ->latest()
            ->get();

        return view('dashboard.barista.pesanan.index', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Urutan tahap: baru -> sedang_dibuat -> siap (beda label utk dine in/take away) -> selesai
        $urutan = [
            'baru'            => 'sedang_dibuat',
            'sedang_dibuat'   => in_array($pesanan->jenis_pesanan, ['dine_in', 'dine_in_qr']) ? 'siap_disajikan' : 'siap_diambil',
            'siap_disajikan'  => 'selesai',
            'siap_diambil'    => 'selesai',
        ];

        $statusBaru = $urutan[$pesanan->status_pesanan] ?? null;

        if (!$statusBaru) {
            return back()->with('error', 'Status pesanan ini sudah tidak bisa diubah lagi.');
        }

        $pesanan->update([
            'status_pesanan' => $statusBaru,
            'barista_id'     => Auth::id(),
        ]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function riwayat()
    {
        $ringkasan = \App\Models\DetailPesanan::whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', 'selesai')
                ->whereDate('updated_at', today());
            })
            ->selectRaw('menu_id, SUM(qty) as total_qty')
            ->groupBy('menu_id')
            ->with('menu')
            ->orderByDesc('total_qty')
            ->get();

        $totalItem = $ringkasan->sum('total_qty');

        return view('dashboard.barista.pesanan.riwayat', compact('ringkasan', 'totalItem'));
    }
}