<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::all();

        return view('dashboard.admin.meja.index', compact('meja'));
    }

    public function create()
    {
        $nextNomor = (Meja::max('nomor_meja') ?? 0) + 1;

    return view('dashboard.admin.meja.create', compact('nextNomor'));
    }

     public function store(Request $request)
    {

       $nextNomor = (Meja::max('nomor_meja') ?? 0) + 1;

        if ($nextNomor > 100) {
            return back()->with('error', 'Sudah mencapai batas maksimal 100 meja.');
        }

        $kodeQr = 'MEJA'
        . str_pad($nextNomor, 3, '0', STR_PAD_LEFT)
        . strtoupper(Str::random(5));

        Meja::create([
            'nomor_meja' => $nextNomor,
            'kode_qr' => $kodeQr,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.meja.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $meja = Meja::findOrFail($id);

        return view('dashboard.admin.meja.edit', compact('meja'));
    }

        public function update(Request $request, $id)
    {
        $meja = Meja::findOrFail($id);

        // Nomor meja tidak lagi bisa diubah lewat form (permanen sejak dibuat),
        // supaya urutannya tetap terjaga dan tidak pernah bolong.
        $kodeQr = 'MEJA'
            . str_pad($meja->nomor_meja, 3, '0', STR_PAD_LEFT)
            . strtoupper(Str::random(5));

        $meja->update([
            'kode_qr' => $kodeQr,
            'status' => $request->status,
            'customer_token' => $request->status === 'kosong'
                ? null
                : $meja->customer_token,
        ]);
        
        return redirect()
            ->route('admin.meja.index')
            ->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meja = Meja::findOrFail($id);

        $meja->delete();

        return redirect()
            ->route('admin.meja.index')
            ->with('success', 'Meja berhasil dihapus.');
    }

    public function qrcode($id)
    {
        $meja = Meja::findOrFail($id);

        return view('dashboard.admin.meja.qrcode', compact('meja'));
    }

    public function download($id)
    {
        $meja = Meja::findOrFail($id);

        $url = request()->getSchemeAndHttpHost() . '/order/' . $meja->kode_qr;

        $result = QrCodeService::generate($url);

        return response(
            $result->getString(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="'.$meja->kode_qr.'.png"',
            ]
        );
    }
}