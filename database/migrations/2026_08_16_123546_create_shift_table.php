<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kasir_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->integer('modal_awal')->default(0);
            $table->integer('uang_fisik')->nullable();
            $table->integer('selisih')->nullable();

            $table->timestamp('waktu_buka');
            $table->timestamp('waktu_tutup')->nullable();

            $table->enum('status', ['buka', 'tutup'])->default('buka');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->foreignId('shift_id')
                ->nullable()
                ->after('id')
                ->constrained('shift')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['shift_id']);
            $table->dropColumn('shift_id');
        });

        Schema::dropIfExists('shift');
    }
};