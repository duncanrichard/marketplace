<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->date('tanggal_order');
            $table->date('tanggal_pengiriman')->nullable();
            $table->string('nama');
            $table->string('telepon');
            $table->text('alamat');
            $table->string('metode');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
}
