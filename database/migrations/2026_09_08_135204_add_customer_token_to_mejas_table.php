<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('meja', function (Blueprint $table) {
            $table->string('customer_token', 64)->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('meja', function (Blueprint $table) {
            $table->dropColumn('customer_token');
        });
    }
};
