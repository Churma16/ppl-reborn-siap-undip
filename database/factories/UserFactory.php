<?php

namespace Database\Factories;


use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $isMahasiswa = $this->faker->boolean(50);
        $nip_nim = $isMahasiswa ? Mahasiswa::factory()->create()->nim : Dosen::factory()->create()->nip;
        $role = $isMahasiswa ? 'mahasiswa' : 'dosen';
        return [
            'nip_nim' => $this->faker->unique()->randomNumber(8),
            'username' => $this->faker->unique()->userName,
            'role' => $role,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
