<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'pesanan_id',
        'metode',
        'order_id',
        'transaction_id',
        'status_pembayaran',
        'waktu_bayar',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}