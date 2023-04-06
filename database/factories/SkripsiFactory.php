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
        $mahasiswa = Mahasiswa::factory()->make();
        return [
            'judul' => $this->faker->sentence,
            'status_konfirmasi' => $this->faker->randomElement(['Belum dikonfirmasi', 'Dikonfirmasi']),
            'status_Skripsi' => $this->faker->randomElement(['Lulus', 'Belum Lulus']),
            'file_skripsi' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'mahasiswa_nim' => $mahasiswa->nim,
        ];
    }
}
