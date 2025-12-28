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
        Schema::table('i_r_s', function (Blueprint $table) {
            // Add status_mahasiswa column
            $table->string('status_mahasiswa')->nullable()->after('status_konfirmasi')->default('Aktif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('i_r_s', function (Blueprint $table) {
            // Drop status_mahasiswa column
            $table->dropColumn('status_mahasiswa');
        });
    }
};
