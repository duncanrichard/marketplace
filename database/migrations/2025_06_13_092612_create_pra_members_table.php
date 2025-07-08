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
       Schema::create('pra_members', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pengajuan_event_id')->constrained()->onDelete('cascade');
    $table->string('nama');
    $table->string('telepon');
    $table->string('email')->nullable();
    $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pra_members');
    }
};
