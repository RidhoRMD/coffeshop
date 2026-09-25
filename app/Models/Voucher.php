<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';

    protected $fillable = [
        'kode',
        'nama_voucher',
        'tipe_diskon',
        'nilai_diskon',
        'minimal_belanja',
        'batas_pemakaian',
        'jumlah_terpakai',
        'tanggal_mulai',
        'tanggal_expired',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_expired' => 'date',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function isValid($totalBelanja)
    {
        if ($this->status !== 'aktif') {
            return ['valid' => false, 'message' => 'Voucher tidak aktif.'];
        }

        if (now()->startOfDay()->lt($this->tanggal_mulai)) {
            return ['valid' => false, 'message' => 'Voucher belum berlaku.'];
        }

        if ($this->tanggal_expired->isPast()) {
            return ['valid' => false, 'message' => 'Voucher sudah kedaluwarsa.'];
        }

        if ($this->batas_pemakaian !== null && $this->batas_pemakaian > 0 && $this->jumlah_terpakai >= $this->batas_pemakaian) {
            return ['valid' => false, 'message' => 'Voucher sudah mencapai batas pemakaian.'];
        }

        if ($this->minimal_belanja !== null && $this->minimal_belanja > 0 && $totalBelanja < $this->minimal_belanja) {
            return ['valid' => false, 'message' => 'Total belanja belum memenuhi syarat minimal voucher ini.'];
        }

        return ['valid' => true, 'message' => 'Voucher valid.'];
    }

    public function hitungDiskon($totalBelanja)
    {
        if ($this->tipe_diskon === 'persen') {
            $diskon = ($this->nilai_diskon / 100) * $totalBelanja;
        } else {
            $diskon = $this->nilai_diskon;
        }

        return min($diskon, $totalBelanja);
    }
}