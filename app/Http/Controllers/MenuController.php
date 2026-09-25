<?php

namespace App\Http\Controllers;

use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MenuController extends Controller
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    public function index()
    {
        $menu = Menu::with('kategori')->latest()->get();

        return view('dashboard.admin.menu.index', compact('menu'));
    }

    public function create()
    {
        $kategori = KategoriMenu::all();

        return view('dashboard.admin.menu.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'harga' => str_replace('.', '', $request->harga),
            'stok'  => str_replace('.', '', $request->stok),
        ]);

        $request->validate([
            'kategori_menu_id' => 'required',
            'nama_menu' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0|max:500',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $namaGambar = time().'.webp';

            $this->imageManager->read($request->gambar)
                ->cover(440, 360)
                ->toWebp(80)
                ->save(public_path('uploads/menu/'.$namaGambar));

            $gambar = $namaGambar;
        }

        Menu::create([
            'kategori_menu_id' => $request->kategori_menu_id,
            'nama_menu'        => $request->nama_menu,
            'deskripsi'        => $request->deskripsi,
            'harga'            => $request->harga,
            'stok'             => $request->stok,
            'status'           => $request->status,
            'gambar'           => $gambar,
        ]);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $kategori = KategoriMenu::all();

        return view('dashboard.admin.menu.edit', compact('menu', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'harga' => str_replace('.', '', $request->harga),
            'stok'  => str_replace('.', '', $request->stok),
        ]);

        $request->validate([
            'kategori_menu_id' => 'required',
            'nama_menu' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0|max:500',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $menu = Menu::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($menu->gambar && file_exists(public_path('uploads/menu/'.$menu->gambar))) {
                unlink(public_path('uploads/menu/'.$menu->gambar));
            }

            $namaGambar = time().'.webp';

            $this->imageManager->read($request->gambar)
                ->cover(440, 360)
                ->toWebp(80)
                ->save(public_path('uploads/menu/'.$namaGambar));

            $menu->gambar = $namaGambar;
        }

        $menu->update([
            'kategori_menu_id' => $request->kategori_menu_id,
            'nama_menu'        => $request->nama_menu,
            'deskripsi'        => $request->deskripsi,
            'harga'            => $request->harga,
            'stok'             => $request->stok,
            'status'           => $request->status,
            'gambar'           => $menu->gambar,
        ]);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && file_exists(public_path('uploads/menu/'.$menu->gambar))) {
            unlink(public_path('uploads/menu/'.$menu->gambar));
        }

        $menu->delete();

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}