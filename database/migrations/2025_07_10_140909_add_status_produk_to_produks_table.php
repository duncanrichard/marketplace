<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('produks', function (Blueprint $table) {
        $table->enum('status_produk', ['aktif', 'tidak_aktif'])->default('aktif')->after('stok');
    });
}

public function down()
{
    Schema::table('produks', function (Blueprint $table) {
        $table->dropColumn('status_produk');
    });
}

};
