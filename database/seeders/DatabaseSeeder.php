<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PKL;
use App\Models\Provinsi;
use App\Models\Skripsi;
use App\Models\User;
use App\Models\KHS;
use App\Models\IRS;
use App\Models\Kabupaten;
use App\Models\Mahasiswa;
use App\Models\Dosen;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Provinsi::factory(10)->create();
        Kabupaten::factory(20)->create();
        Dosen::factory(20)->create();
        Mahasiswa::factory(20)->create();
        IRS::factory(20)->create();
        KHS::factory(20)->create();
        PKL::factory(15)->create();
        Skripsi::factory(10)->create();
        User::factory(39)->create();

    }
}
