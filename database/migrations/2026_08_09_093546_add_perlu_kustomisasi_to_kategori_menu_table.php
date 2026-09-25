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
        Schema::table('kategori_menu', function (Blueprint $table) {
            $table->boolean('perlu_kustomisasi')->default(true)->after('nama_kategori');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_menu', function (Blueprint $table) {
            $table->dropColumn('perlu_kustomisasi');
        });
    }
};
