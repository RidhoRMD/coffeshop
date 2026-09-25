<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Meja;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barista;
class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'shift_id',
        'barista_id',
        'kode_pesanan',
        'jenis_pesanan',
        'meja_id',
        'nama_customer',
        'total',
        'status_pesanan',
        'status_pembayaran',
        'voucher_id',
        'diskon',
    ];

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function barista()
    {
        return $this->belongsTo(User::class, 'barista_id');
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}