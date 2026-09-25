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
       Schema::create('meja', function (Blueprint $table) {
            $table->id();

            $table->integer('nomor_meja')->unique();
            $table->string('kode_qr')->unique();
            $table->boolean('is_active')->default(true);

            $table->enum('status',[
            'kosong',
            'dipesan',
            'nonaktif'
        ])->default('kosong');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mejas');
    }
};
