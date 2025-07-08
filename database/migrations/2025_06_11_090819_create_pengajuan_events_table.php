<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_events', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->string('kategori');
            $table->enum('status', ['Pending', 'Ditolak', 'Confirmed'])->default('Pending');
            $table->string('lokasi');
            $table->integer('target')->nullable();
            $table->json('jenis_target')->nullable();
            $table->string('pic_nama')->nullable();
            $table->string('pic_telp')->nullable();
            $table->bigInteger('anggaran')->nullable();
            $table->integer('jumlah_tim');
            $table->text('deskripsi')->nullable();
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_events');
    }
};
