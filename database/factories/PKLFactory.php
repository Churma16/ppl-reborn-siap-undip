<?php

namespace Database\Factories;

use App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PKL>
 */
class PKLFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $mahasiswa = Mahasiswa::all()->random()->nim;
        return [
            'status_lulus' => $this->faker->randomElement(['Lulus', 'Belum Lulus']),
            'nama_perusahaan' => $this->faker->company,
            'tanggal_mulai' => $this->faker->date(),
            'status_konfirmasi' => $this->faker->randomElement(['Sudah Konfirmasi', 'Belum Konfirmasi']),
            'file_pkl' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'mahasiswa_nim' => $mahasiswa,
        ];
    }
}
