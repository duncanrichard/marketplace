<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusReservasiToReservasiTable extends Migration
{
    public function up()
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->enum('status_reservasi', ['Pending', 'Dikonfirmasi', 'Batal', 'Booked', 'Reschedule'])
                  ->default('Pending')
                  ->after('jam_reservasi');
        });
    }

    public function down()
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn('status_reservasi');
        });
    }
}
