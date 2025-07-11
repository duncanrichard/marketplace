<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananItemsTable extends Migration
{
    public function up()
    {
        Schema::create('pesanan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('produk_id')->nullable(); // opsional, jika kamu ingin relasi
            $table->string('nama_produk');
            $table->integer('harga');
            $table->integer('qty');
            $table->integer('total');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan_items');
    }
}
