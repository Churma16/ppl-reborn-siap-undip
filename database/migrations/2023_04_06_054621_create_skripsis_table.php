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
        Schema::create('skripsis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('status_konfirmasi')->default('Belum dikonfirmasi');
            $table->string('status_skripsi')->default('Belum lulus');
            $table->date('tanggal_sidang')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->string('file_skripsi');
            $table->string('nilai')->nullable();
            $table->string('rincian_progress')->nullable();
            $table->string('progress_ke')->nullable();
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
        Schema::dropIfExists('skripsis');
    }
};
