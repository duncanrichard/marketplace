<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlToNotifikasisTable extends Migration
{
    /**
     * Tambahkan kolom 'url' ke tabel 'notifikasis'
     */
    public function up(): void
    {
        Schema::table('notifikasis', function (Blueprint $table) {
            $table->string('url')->nullable()->after('pesan');
        });
    }

    /**
     * Hapus kolom 'url' jika rollback
     */
    public function down(): void
    {
        Schema::table('notifikasis', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
}
