<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusReservasiEnumInReservasisTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE reservasis MODIFY status_reservasi ENUM('Booked', 'Pending', 'Batal', 'Dikonfirmasi', 'Reschedule') DEFAULT 'Pending'");
    }

    public function down()
    {
        // Kembalikan ke enum sebelumnya (tanpa 'Reschedule'), sesuaikan isi enum lama sesuai kondisi awal
        DB::statement("ALTER TABLE reservasis MODIFY status_reservasi ENUM('Booked', 'Pending', 'Batal', 'Dikonfirmasi') DEFAULT 'Pending'");
    }
}
