<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function bukaForm()
    {
        $shiftAktif = Shift::where('kasir_id', Auth::id())
            ->where('status', 'buka')
            ->first();

        if ($shiftAktif) {
            return redirect()->route('kasir.dashboard');
        }

        return view('dashboard.kasir.shift.buka');
    }

    public function buka(Request $request)
    {
        $request->validate([
            'modal_awal' => 'required|integer|min:0',
        ]);

        Shift::create([
            'kasir_id'    => Auth::id(),
            'modal_awal'  => $request->modal_awal,
            'waktu_buka'  => now(),
            'status'      => 'buka',
        ]);

        return redirect()
            ->route('kasir.dashboard')
            ->with('success', 'Shift berhasil dibuka. Selamat bekerja!');
    }

    public function tutupForm()
    {
        $shiftAktif = Shift::where('kasir_id', Auth::id())
            ->where('status', 'buka')
            ->firstOrFail();

        $pesananShift = Pesanan::where('shift_id', $shiftAktif->id)
            ->where('status_pembayaran', 'berhasil');

        $totalTransaksi = (clone $pesananShift)->count();
        $totalPenjualan = (clone $pesananShift)->sum('total');

        $totalTunai = (clone $pesananShift)
            ->whereHas('pembayaran', function ($q) {
                $q->where('metode', 'tunai');
            })->sum('total');

        $totalQris = (clone $pesananShift)
            ->whereHas('pembayaran', function ($q) {
                $q->where('metode', 'QRIS');
            })->sum('total');

        $uangSeharusnya = $shiftAktif->modal_awal + $totalTunai;

        return view('dashboard.kasir.shift.tutup', compact(
            'shiftAktif', 'totalTransaksi', 'totalPenjualan',
            'totalTunai', 'totalQris', 'uangSeharusnya'
        ));
    }

    public function tutup(Request $request)
    {
        $request->validate([
            'uang_fisik' => 'required|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        $shiftAktif = Shift::where('kasir_id', Auth::id())
            ->where('status', 'buka')
            ->firstOrFail();

        $totalTunai = Pesanan::where('shift_id', $shiftAktif->id)
            ->where('status_pembayaran', 'berhasil')
            ->whereHas('pembayaran', function ($q) {
                $q->where('metode', 'tunai');
            })->sum('total');

        $uangSeharusnya = $shiftAktif->modal_awal + $totalTunai;
        $selisih = $request->uang_fisik - $uangSeharusnya;

        $shiftAktif->update([
            'uang_fisik'   => $request->uang_fisik,
            'selisih'      => $selisih,
            'waktu_tutup'  => now(),
            'status'       => 'tutup',
            'catatan'      => $request->catatan,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Shift berhasil ditutup. Sampai jumpa lagi!');
    }
}