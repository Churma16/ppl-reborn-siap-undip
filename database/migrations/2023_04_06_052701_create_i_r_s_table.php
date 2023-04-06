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
        Schema::create('i_r_s', function (Blueprint $table) {
            $table->id();
            $table->integer('semester_aktif');
            $table->string('status_konfirmasi')->default('Belum dikonfirmasi');
            $table->integer('jumlah_sks');
            $table->string('file_sks');
            $table->foreignid('mahasiswa_nim');
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
        Schema::dropIfExists('i_r_s');
    }
};
