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
        Schema::create('strategic_partnerships', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kerjasama')->unique();
            $table->string('nama_kerjasama');
            $table->date('tanggal_kerjasama');
            $table->date('tanggal_selesai');
            $table->string('nama_marketing');
            $table->string('nama_pic');
            $table->string('telepon_pic');
            $table->string('dokumen')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strategic_partnerships');
    }
};
