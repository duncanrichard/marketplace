<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPesanansTable extends Migration
{
    public function up()
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->enum('status', [
                'Pesanan Di Proses',
                'Pesanan Di Kirim',
                'Pesanan Selesai'
            ])->default('Pesanan Di Proses')->after('metode');
        });
    }

    public function down()
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
