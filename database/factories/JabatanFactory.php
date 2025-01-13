<?php

namespace Database\Factories;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jabatan>
 */
class JabatanFactory extends Factory
{
    protected $model = Jabatan::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->jobTitle, // Nama jabatan akan diisi dengan data acak
        ];
    }
}
