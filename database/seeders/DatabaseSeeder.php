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
        User::create([
            'nip_nim' => '30',
            'username' => 'admin',
            'role' => '1',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'nip_nim' => '65',
            'username' => 'departemen',
            'role' => '2',
            'password' => bcrypt('password'),
        ]);

        $firstDosen = Dosen::all()->first();

        // $jsonValue = Dosen::select('nip')->first();
        // $data = json_decode($jsonValue);
        // $nip = $data->nip;
        // // Convert the nip value to an integer
        // $nip = intval($nip);

        User::create([
            'nip_nim' => $firstDosen['nip'],
            'username' => 'dosen',
            'role' => '3',
            'password' => bcrypt('password'),
        ]);


        $firstMhs = Mahasiswa::all()->first();
        User::create([
            'nip_nim' => $firstMhs['nim'],
            'username' => 'mahasiswa',
            'role' => '4',
            'password' => bcrypt('password'),
        ]);

        // User::factory(39)->create();

    }
}
