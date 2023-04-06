<?php

namespace Database\Factories;

use App\Models\Provinsi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kabupaten>
 */
class KabupatenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $provinsi = Provinsi::factory()->create();

        return [
            'nama' => $this->faker->city,
            'provinsi_kode_provinsi' => $this->faker->randomNumber(1,30),
        ];
    }
}
