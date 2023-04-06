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
        $kode_wali = $this->faker->regexify('[A-Z][0-9]');
        return [
            'nip' => $this->faker->unique()->randomNumber(8),
            'kode_wali' => $kode_wali,
            'nama' => $this->faker->name,
            'foto_dosen' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'email' => $this->faker->unique()->safeEmail,
            'no_hp' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
        ];
    }
}
