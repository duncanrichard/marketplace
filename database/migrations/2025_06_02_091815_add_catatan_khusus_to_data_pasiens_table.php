<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatatanKhususToDataPasiensTable extends Migration
{
    public function up()
    {
        Schema::table('data_pasiens', function (Blueprint $table) {
            // Tambahkan catatan_pasien terlebih dahulu
            if (!Schema::hasColumn('data_pasiens', 'catatan_pasien')) {
                $table->text('catatan_pasien')->nullable()->after('keterangan');
            }

            // Tambahkan telat & tidak_dilayani
            $table->boolean('telat')->default(false)->after('catatan_pasien');
            $table->boolean('tidak_dilayani')->default(false)->after('telat');
        });
    }

    public function down()
    {
        Schema::table('data_pasiens', function (Blueprint $table) {
            $table->dropColumn(['catatan_pasien', 'telat', 'tidak_dilayani']);
        });
    }
}
