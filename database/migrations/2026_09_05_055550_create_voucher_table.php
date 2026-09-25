<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->id();

            $table->string('kode')->unique();
            $table->string('nama_voucher');
            $table->enum('tipe_diskon', ['persen', 'nominal']);
            $table->integer('nilai_diskon');
            $table->integer('minimal_belanja')->default(0);
            $table->integer('batas_pemakaian')->default(0);
            $table->integer('jumlah_terpakai')->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_expired');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->foreignId('voucher_id')
                ->nullable()
                ->after('barista_id')
                ->constrained('voucher')
                ->nullOnDelete();

            $table->integer('diskon')->default(0)->after('total');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn(['voucher_id', 'diskon']);
        });

        Schema::dropIfExists('voucher');
    }
};