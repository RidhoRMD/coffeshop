<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $voucher = Voucher::latest()->get();

        return view('dashboard.admin.voucher.index', compact('voucher'));
    }

    public function create()
    {
        return view('dashboard.admin.voucher.create');
    }

    private function validasiNilaiDiskon(Request $request)
    {
        if ($request->tipe_diskon === 'persen' && ($request->nilai_diskon < 1 || $request->nilai_diskon > 100)) {
            return 'Nilai diskon persentase harus antara 1 - 100.';
        }

        if ($request->tipe_diskon === 'nominal' && ($request->nilai_diskon < 10000 || $request->nilai_diskon > 500000)) {
            return 'Nilai diskon nominal harus antara Rp 10.000 - Rp 500.000.';
        }

        return null;
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:voucher,kode',
            'tipe_diskon' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|integer|min:1',
            'minimal_belanja' => 'required|integer|min:10000|max:1000000',
            'batas_pemakaian' => 'nullable|integer|min:0|max:1000',
            'status' => 'required|in:aktif,nonaktif',
            'tanggal_mulai' => 'required|date',
            'tanggal_expired' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        if ($pesan = $this->validasiNilaiDiskon($request)) {
            return back()->withInput()->with('error', $pesan);
        }

        $kode = strtoupper($request->kode);

        Voucher::create([
            'kode' => $kode,
            'nama_voucher' => $kode, // nama_voucher otomatis disamakan dengan kode, gak ada input terpisah lagi
            'tipe_diskon' => $request->tipe_diskon,
            'nilai_diskon' => $request->nilai_diskon,
            'minimal_belanja' => $request->minimal_belanja,
            'batas_pemakaian' => $request->batas_pemakaian ?? 0,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_expired' => $request->tanggal_expired,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.voucher.index')
            ->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);

        return view('dashboard.admin.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:20|unique:voucher,kode,' . $voucher->id,
            'tipe_diskon' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|integer|min:1',
            'minimal_belanja' => 'required|integer|min:10000|max:1000000',
            'batas_pemakaian' => 'nullable|integer|min:0|max:1000',
            'status' => 'required|in:aktif,nonaktif',
            'tanggal_mulai' => 'required|date',
            'tanggal_expired' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        if ($pesan = $this->validasiNilaiDiskon($request)) {
            return back()->withInput()->with('error', $pesan);
        }

        $kode = strtoupper($request->kode);

        $voucher->update([
            'kode' => $kode,
            'nama_voucher' => $kode, // ikut disamakan tiap kode diubah
            'tipe_diskon' => $request->tipe_diskon,
            'nilai_diskon' => $request->nilai_diskon,
            'minimal_belanja' => $request->minimal_belanja,
            'batas_pemakaian' => $request->batas_pemakaian ?? 0,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_expired' => $request->tanggal_expired,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.voucher.index')
            ->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()
            ->route('admin.voucher.index')
            ->with('success', 'Voucher berhasil dihapus.');
    }
}