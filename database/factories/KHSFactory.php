<?php

namespace Database\Factories;

use App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KHS>
 */
class KHSFactory extends Factory
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
            'semester' => $this->faker->randomNumber(1, 14),
            'status_konfirmasi' => $this->faker->randomElement(['Belum dikonfirmasi', 'Dikonfirmasi']),
            'status_mahasiswa' => $this->faker->randomElement(['Aktif']),
            'ip_semester' => $this->faker->randomFloat(2, 0, 4),
            'ip_kumulatif' => $this->faker->randomFloat(2, 0, 4),
            'sks_kumulatif' => $this->faker->numberBetween(1, 144),
            'file_khs' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'mahasiswa_nim' => $mahasiswa,
        ];
    }
}
