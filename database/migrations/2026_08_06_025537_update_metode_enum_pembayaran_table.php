<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pembayaran MODIFY metode ENUM('QRIS', 'tunai') DEFAULT 'QRIS'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE pembayaran MODIFY metode ENUM('QRIS') DEFAULT 'QRIS'");
    }
};