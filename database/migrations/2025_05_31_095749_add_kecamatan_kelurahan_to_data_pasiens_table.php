<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKecamatanKelurahanToDataPasiensTable extends Migration
{
    public function up()
    {
        Schema::table('data_pasiens', function (Blueprint $table) {
            $table->string('kecamatan')->nullable()->after('kota');
            $table->string('kelurahan')->nullable()->after('kecamatan');
        });
    }

    public function down()
    {
        Schema::table('data_pasiens', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'kelurahan']);
        });
    }
}
