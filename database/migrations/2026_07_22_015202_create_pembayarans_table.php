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
       Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pesanan_id')
                ->constrained('pesanan')
                ->cascadeOnDelete();

            $table->enum('metode', [
                'QRIS'
            ])->default('QRIS');

            $table->string('order_id')->nullable();
            $table->string('transaction_id')->nullable();

            $table->enum('status_pembayaran', [
                'pending',
                'lunas',
                'gagal',
                'expired',
                'dibatalkan'
            ])->default('pending');

            $table->timestamp('waktu_bayar')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
