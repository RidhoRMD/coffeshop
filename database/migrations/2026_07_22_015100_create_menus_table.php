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
    Schema::create('menu', function (Blueprint $table) {
        $table->id();

        $table->foreignId('kategori_menu_id')
            ->constrained('kategori_menu')
            ->cascadeOnDelete();

        $table->string('nama_menu');
        $table->text('deskripsi')->nullable();
        $table->integer('harga');
        $table->integer('stok')->default(0);
        $table->string('gambar')->nullable();

        $table->enum('status', [
            'tersedia',
            'habis'
        ])->default('tersedia');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
