<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDataPasiensTable extends Migration
{
    public function up()
    {
        Schema::table('data_pasiens', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('agama')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->date('tanggal_pendaftaran')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('no_hp_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('foto')->nullable();
        });
    }

    public function down()
    {
        Schema::table('data_pasiens', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin', 'tempat_lahir', 'no_hp', 'email', 'agama',
                'status_pernikahan', 'golongan_darah', 'pendidikan', 'pekerjaan',
                'tanggal_pendaftaran', 'keterangan', 'nama_wali', 'hubungan',
                'no_hp_wali', 'alamat_wali', 'provinsi', 'kota', 'foto'
            ]);
        });
    }
}
