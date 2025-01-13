<?php

namespace Database\Factories;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;

    public function definition()
    {
        return [
            'nip' => $this->faker->unique()->numerify('########'),
            'nama' => $this->faker->name,
            'tahun_masuk' => $this->faker->year($max = 'now'),
            'gaji_pokok' => $this->faker->numberBetween(3000000, 10000000),
            'jabatan_id' => Jabatan::factory(),
            'jam_lembur' => $this->faker->numberBetween(0, 50),
            'jumlah_pelanggan' => $this->faker->numberBetween(0, 100),
            'peningkatan_penjualan' => $this->faker->numberBetween(0, 100),
        ];
    }
}
