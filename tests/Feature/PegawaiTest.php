<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PegawaiTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_gaji_akhir_for_sales()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Sales']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 5000000,
            'jumlah_pelanggan' => 20,
        ]);

        $this->assertEquals(6000000, $pegawai->hitungGajiAkhir($pegawai));
    }

    public function test_calculate_gaji_akhir_for_satpam()
    {
    $jabatan = Jabatan::factory()->create(['nama' => 'Satpam']);
    $pegawai = Pegawai::factory()->create([
        'jabatan_id' => $jabatan->id,
        'gaji_pokok' => 4000000,
        'jam_lembur' => 15,
    ]);

    $this->assertEquals(4300000, $pegawai->hitungGajiAkhir($pegawai));
    }

}
