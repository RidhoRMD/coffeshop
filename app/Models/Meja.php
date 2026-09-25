<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'meja';

    protected $fillable = [
        'nomor_meja',
        'kode_qr',
        'status',
        'customer_token',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
    
}