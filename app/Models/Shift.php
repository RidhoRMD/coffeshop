<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shift';

    protected $fillable = [
        'kasir_id',
        'modal_awal',
        'uang_fisik',
        'selisih',
        'waktu_buka',
        'waktu_tutup',
        'status',
        'catatan',
    ];

    protected $casts = [
        'waktu_buka' => 'datetime',
        'waktu_tutup' => 'datetime',
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}