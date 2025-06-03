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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('username')->nullable();
        $table->string('activity'); // contoh: "Menambahkan Pasien", "Login"
        $table->string('module')->nullable(); // contoh: "Data Pasien"
        $table->string('ip_address')->nullable();
        $table->string('user_agent')->nullable();
        $table->timestamp('logged_at')->useCurrent();
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
        Schema::dropIfExists('activity_logs');
    }
};
