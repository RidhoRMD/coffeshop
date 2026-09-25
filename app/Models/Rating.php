<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';

    protected $fillable = [
        'detail_pesanan_id',
        'menu_id',
        'bintang',
        'komentar',
    ];

    public function detailPesanan()
    {
        return $this->belongsTo(DetailPesanan::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}