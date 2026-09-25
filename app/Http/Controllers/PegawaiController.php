<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = User::latest()->get();

        return view('dashboard.admin.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('dashboard.admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,kasir,barista',
            'status' => 'required|in:aktif,nonaktif',
        ],
        [
        'name.required' => 'Nama pegawai wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        'role.required' => 'Silakan pilih role.',
        'status.required' => 'Silakan pilih status.',
     ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = User::findOrFail($id);

        return view('dashboard.admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = User::findOrFail($id);

        $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $pegawai->id,
        'password' => 'nullable|min:6',
        'role' => 'required|in:admin,kasir,barista',
        'status' => 'required|in:aktif,nonaktif',
    ],[
        'name.required' => 'Nama pegawai wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'password.min' => 'Password minimal 6 karakter.',
        'role.required' => 'Silakan pilih role.',
        'status.required' => 'Silakan pilih status.',
    ]);

        $pegawai->name = $request->name;
        $pegawai->email = $request->email;
        $pegawai->role = $request->role;
        $pegawai->status = $request->status;

        if ($request->filled('password')) {
            $pegawai->password = Hash::make($request->password);
        }

        $pegawai->save();

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = User::findOrFail($id);

        $pegawai->delete();

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }

    public function show($id)
    {
        $pegawai = User::findOrFail($id);

        return view('dashboard.admin.pegawai.show', compact('pegawai'));
    }

    public function shiftIndex()
    {
        $shift = Shift::with('kasir')->latest()->get();

        return view('dashboard.admin.shift.index', compact('shift'));
    }

    public function shiftShow($id)
    {
        $shiftDetail = Shift::with(['kasir', 'pesanan.meja'])->findOrFail($id);

        return view('dashboard.admin.shift.show', compact('shiftDetail'));
    }
}