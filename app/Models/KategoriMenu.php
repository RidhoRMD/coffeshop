<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    protected $table = 'kategori_menu';

    protected $fillable = [
        'nama_kategori',
        'perlu_kustomisasi',
    ];

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    
}