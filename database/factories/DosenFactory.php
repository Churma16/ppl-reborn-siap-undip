<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $kodeWali = $this->faker->regexify('[A-Z][A-Z][0-9][0-9]');
        return [
            'nip' => $this->faker->unique()->numberBetween(60, 150),
            'kode_wali' => $kodeWali,
            'nama' => $this->faker->name,
            'foto_dosen' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'email' => $this->faker->unique()->safeEmail,
            'no_hp' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
        ];
    }
}
