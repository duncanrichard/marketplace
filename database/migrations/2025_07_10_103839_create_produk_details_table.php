<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('produk_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');
            $table->string('ukuran')->nullable();
            $table->string('berat')->nullable();
            $table->string('rasa')->nullable();
            $table->string('warna')->nullable();
            $table->string('merk')->nullable();
            $table->timestamps();

            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk_details');
    }
}
