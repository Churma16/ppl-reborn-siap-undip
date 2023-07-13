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
        Schema::create('k_h_s', function (Blueprint $table) {
            $table->id();
            $table->integer('semester');
            $table->string('status_konfirmasi')->default('Belum dikonfirmasi');
            $table->string('status_mahasiswa');
            $table->float('ip_semester');
            $table->float('ip_kumulatif');
            $table->integer('sks_kumulatif');
            $table->string('file_khs');
            $table->foreignId('mahasiswa_nim');
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
        Schema::dropIfExists('k_h_s');
    }
};
