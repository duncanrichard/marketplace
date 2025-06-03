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
       Schema::create('reservasis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pasien_id')->constrained('data_pasiens')->onDelete('cascade');
    $table->date('tanggal_reservasi');
    $table->time('jam_reservasi');
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
        Schema::dropIfExists('reservasis');
    }
};
