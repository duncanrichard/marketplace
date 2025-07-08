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
    Schema::create('event_kebutuhans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pengajuan_event_id')->constrained()->onDelete('cascade');
        $table->string('nama');
        $table->integer('jumlah');
        $table->date('tanggal');
        $table->enum('status', ['Beli', 'Pinjam']);
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
        Schema::dropIfExists('event_kebutuhans');
    }
};
