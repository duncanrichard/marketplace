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
    Schema::create('produks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kategori_id')->constrained()->onDelete('cascade');
        $table->string('nama');
        $table->text('deskripsi')->nullable();
        $table->integer('harga');
        $table->integer('stok');
        $table->string('foto')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
};
