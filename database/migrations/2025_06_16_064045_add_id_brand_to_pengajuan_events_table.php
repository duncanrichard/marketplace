<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pengajuan_events', function (Blueprint $table) {
            $table->foreignId('id_brand')
                ->nullable()
                ->constrained('brands')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pengajuan_events', function (Blueprint $table) {
            $table->dropForeign(['id_brand']);
            $table->dropColumn('id_brand');
        });
    }
};
