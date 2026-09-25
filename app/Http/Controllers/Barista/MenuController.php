<?php

namespace App\Http\Controllers\Barista;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::with('kategori')->orderBy('nama_menu')->get();

        return view('dashboard.barista.menu.index', compact('menu'));
    }

    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->update([
            'status' => $menu->status === 'tersedia' ? 'habis' : 'tersedia',
        ]);

        return back()->with('success', 'Status menu diperbarui.');
    }

   public function updateStok(Request $request, $id)
    {
        $request->merge([
            'stok' => str_replace('.', '', $request->stok),
        ]);

        $request->validate([
            'stok' => 'required|integer|min:0|max:500',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'stok' => $request->stok,
            'status' => $request->stok > 0 ? 'tersedia' : 'habis',
        ]);

        return back()->with('success', 'Stok menu berhasil diperbarui!');
    }
}