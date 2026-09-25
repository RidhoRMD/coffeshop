<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();

            $table->string('kode_pesanan')->unique();

            $table->enum('jenis_pesanan', [
                'dine_in',
                'takeaway'
            ]);

            $table->foreignId('meja_id')
                ->nullable()
                ->constrained('meja')
                ->nullOnDelete();

            $table->string('nama_customer')->nullable();

            $table->integer('total')->default(0);

            $table->enum('status_pesanan', [
            'baru',
            'sedang_dibuat',
            'siap_disajikan',
            'siap_diambil',
            'selesai'
        ])->default('baru');

        $table->enum('status_pembayaran', [
            'menunggu',
            'berhasil',
            'dibatalkan'
        ])->default('menunggu');
            
            $table->timestamps();
        });
       }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
