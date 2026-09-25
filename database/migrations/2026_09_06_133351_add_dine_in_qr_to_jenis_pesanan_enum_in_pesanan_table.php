<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pesanan MODIFY jenis_pesanan ENUM('dine_in', 'takeaway', 'dine_in_qr') NOT NULL");
    }

    public function down(): void
    {
        // Pastikan tidak ada data 'dine_in_qr' lagi sebelum rollback, kalau tidak akan error
        DB::statement("UPDATE pesanan SET jenis_pesanan = 'dine_in' WHERE jenis_pesanan = 'dine_in_qr'");
        DB::statement("ALTER TABLE pesanan MODIFY jenis_pesanan ENUM('dine_in', 'takeaway') NOT NULL");
    }
};