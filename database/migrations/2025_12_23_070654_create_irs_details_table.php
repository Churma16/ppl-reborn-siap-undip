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
        Schema::create('irs_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('irs_id')->constrained('irs')->onDelete('cascade');
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliah');
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
        Schema::dropIfExists('irs_details');
    }
};
