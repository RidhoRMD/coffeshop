<?php

namespace App\Http\Controllers;

use App\Models\KategoriMenu;
use Illuminate\Http\Request;

class KategoriMenuController extends Controller
{
    public function index()
    {
        $kategori = KategoriMenu::latest()->get();

        return view('dashboard.admin.kategori-menu.index', compact('kategori'));
    }

    public function create()
    {
        return view('dashboard.admin.kategori-menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategori_menu,nama_kategori',
        ]);

        KategoriMenu::create([
            'nama_kategori'      => $request->nama_kategori,
            'perlu_kustomisasi'  => $request->has('perlu_kustomisasi'),
        ]);

        return redirect()
            ->route('admin.kategori-menu.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $kategori = KategoriMenu::findOrFail($id);

        return view('dashboard.admin.kategori-menu.edit', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategori_menu,nama_kategori,' . $id,
        ]);

        $kategori = KategoriMenu::findOrFail($id);

        $kategori->update([
            'nama_kategori'      => $request->nama_kategori,
            'perlu_kustomisasi'  => $request->has('perlu_kustomisasi'),
        ]);

        return redirect()
            ->route('admin.kategori-menu.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriMenu::findOrFail($id);

        if ($kategori->menu()->exists()) {
            return redirect()
                ->route('admin.kategori-menu.index')
                ->with('error', 'Kategori ini tidak bisa dihapus karena masih ada menu di dalamnya. Hapus atau pindahkan menunya dulu.');
        }

        $kategori->delete();

        return redirect()
            ->route('admin.kategori-menu.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}