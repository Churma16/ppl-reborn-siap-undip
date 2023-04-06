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
        $mahasiswa = Mahasiswa::factory()->create();
        return [
            'semester' => $this->faker->randomNumber(1,14),
            'status_konfirmasi' => $this->faker->randomElement(['Belum dikonfirmasi', 'Dikonfirmasi']),
            'status_konfirmasi' => $this->faker->randomElement(['Aktif']),
            'ip_semester' => $this->faker->randomFloat(1,4),
            'ip_kumulatif' => $this->faker->randomFloat(1,4),
            'sks_kumulatif' => $this->faker->randomNumber(1,144),
            'mahasiswa_nim' => $mahasiswa->nim,
        ];
    }
}
