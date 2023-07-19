<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skripsi>
 */
class SkripsiFactory extends Factory
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
            'judul' => $this->faker->sentence,
            'status_konfirmasi' => $this->faker->randomElement(['Belum Dikonfirmasi', 'Dikonfirmasi']),
            'status_Skripsi' => $this->faker->randomElement(['Lulus', 'Belum Lulus']),
            'file_skripsi' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'mahasiswa_nim' => $mahasiswa,
            'rincian_progress' => $this->faker->sentence,
            'progress_ke' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6']),
            'tanggal_mulai' => $this->faker->date(),
        ];
    }
}
