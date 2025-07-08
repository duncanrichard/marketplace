<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pra_members', function (Blueprint $table) {
            $table->unsignedBigInteger('pengajuan_event_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pra_members', function (Blueprint $table) {
            $table->unsignedBigInteger('pengajuan_event_id')->nullable(false)->change();
        });
    }
};