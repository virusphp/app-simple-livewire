<?php

namespace Database\Factories;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{

    protected $model = Pasien::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'user_id' => User::factory(),
            'nama_pasien' => $this->faker->name(),
            'alamat_pasien' => $this->faker->address(),
            'tanggal_lahir' => $this->faker->date('Y-m-d'),
            'tempat_lahir' => $this->faker->streetName(),
            'aktif' => $this->faker->boolean()
        ];
    }
}
