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
            $table->foreignId('semester_id')->after('mahasiswa_nim');
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
            $table->dropColumn('semester_id');
        });
    }
};
