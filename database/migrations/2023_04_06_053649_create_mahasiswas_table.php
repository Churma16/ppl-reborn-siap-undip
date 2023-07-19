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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id('nim');
            $table->string('nama');
            $table->string('foto_mahasiswa')->nullable();
            $table->integer('angkatan');
            $table->string('email')->unique();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('jalur_masuk');
            $table->foreignId('provinsi_kode_provinsi')->nullable();
            $table->foreignId('kabupaten_kode_kabupaten')->nullable();
            $table->foreignUuid('dosen_kode_wali');
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
        Schema::dropIfExists('mahasiswas');
    }
};
