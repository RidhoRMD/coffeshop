<?php

namespace App\Services;

use App\Models\Meja;
use App\Models\Pesanan;

class TandaPembaruan
{
    /**
     * Sidik singkat kondisi pesanan saat ini. Berubah kalau ada pesanan baru,
     * pesanan dihapus, atau status/pembayarannya berubah.
     */
    public static function pesanan(): string
    {
        return md5(implode('|', [
            Pesanan::count(),
            Pesanan::max('updated_at'),
            Meja::where('status', 'dipesan')->count(),
        ]));
    }
}