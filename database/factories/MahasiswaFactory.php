<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Kabupaten;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dosen = Dosen::factory()->create();
        $kodeKabupaten = Kabupaten::factory()->create();
        return [
            'nim'=> $this->faker->unique()->randomNumber(14),
            'nama' => $this->faker->name,
            'foto_mahasiswa' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'angkatan' => $this->faker->randomNumber(2000,2021),
            'email' => $this->faker->unique()->safeEmail,
            'alamat' => $this->faker->address,
            'no_hp' => $this->faker->phoneNumber,
            'jalur_masuk'=> $this->faker->randomElement(['SNMPTN', 'SBMPTN', 'Mandiri']),
            'provinsi_kode_provinsi' => $kodeKabupaten->provinsi_kode_provinsi,
            'kabupaten_kode_kabupaten' => $kodeKabupaten->kode_kabupaten,
            'dosen_kode_wali' => $dosen->kode_wali,



        ];
    }
}
