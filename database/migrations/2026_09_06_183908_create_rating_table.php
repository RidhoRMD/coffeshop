<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->id();

            $table->foreignId('detail_pesanan_id')
                ->unique()
                ->constrained('detail_pesanan')
                ->cascadeOnDelete();

            $table->foreignId('menu_id')
                ->constrained('menu')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('bintang');
            $table->text('komentar')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};