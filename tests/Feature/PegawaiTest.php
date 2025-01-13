<?php

namespace Tests\Feature;

use App\Http\Controllers\PegawaiController;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PegawaiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Positive Test Case: Valid input for Sales.
     */
    public function test_calculate_gaji_for_sales_valid_input()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Sales']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 5000000,
            'jumlah_pelanggan' => 10,
        ]);

        $expectedGajiAkhir = 5000000 + (10 * 50000);
        $this->assertEquals($expectedGajiAkhir, $pegawai->hitungGajiAkhir());
    }

    /**
     * Positive Test Case: Valid input for Satpam.
     */
    public function test_calculate_gaji_for_satpam_valid_input()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Satpam']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 4000000,
            'jam_lembur' => 5,
        ]);

        $expectedGajiAkhir = 4000000 + (5 * 20000);
        $this->assertEquals($expectedGajiAkhir, $pegawai->hitungGajiAkhir());
    }

    public function test_calculate_gaji_for_sales_missing_pelanggan()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Sales']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 5000000,
            'jumlah_pelanggan' => -1
        ]);

        $controller = new PegawaiController();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Jumlah pelanggan tidak valid.');

        $controller->testHitungGajiAkhir($pegawai);
    }

    public function test_calculate_gaji_for_satpam_negative_lembur()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Satpam']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 4000000,
            'jam_lembur' => -5, // Nilai negatif untuk menguji validasi
        ]);

        $controller = new PegawaiController();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Jam lembur tidak valid.');

        $controller->testHitungGajiAkhir($pegawai);
    }

    /**
     * Boundary Test Case: Sales with jumlah_pelanggan = 0.
     */
    public function test_calculate_gaji_for_sales_boundary_min()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Sales']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 5000000,
            'jumlah_pelanggan' => 0,
        ]);

        $expectedGajiAkhir = 5000000; // No pelanggan, no bonus
        $this->assertEquals($expectedGajiAkhir, $pegawai->hitungGajiAkhir());
    }

    /**
     * Boundary Test Case: Satpam with jam_lembur = 0.
     */
    public function test_calculate_gaji_for_satpam_boundary_min()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Satpam']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 4000000,
            'jam_lembur' => 0,
        ]);

        $expectedGajiAkhir = 4000000; // No lembur, no bonus
        $this->assertEquals($expectedGajiAkhir, $pegawai->hitungGajiAkhir());
    }

    /**
     * Boundary Test Case: Sales with high jumlah_pelanggan.
     */
    public function test_calculate_gaji_for_sales_boundary_max()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Sales']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 5000000,
            'jumlah_pelanggan' => 1000, // Large number of pelanggan
        ]);

        $expectedGajiAkhir = 5000000 + (1000 * 50000);
        $this->assertEquals($expectedGajiAkhir, $pegawai->hitungGajiAkhir());
    }

    /**
     * Boundary Test Case: Satpam with high jam_lembur.
     */
    public function test_calculate_gaji_for_satpam_boundary_max()
    {
        $jabatan = Jabatan::factory()->create(['nama' => 'Satpam']);
        $pegawai = Pegawai::factory()->create([
            'jabatan_id' => $jabatan->id,
            'gaji_pokok' => 4000000,
            'jam_lembur' => 100, // Large number of lembur hours
        ]);

        $expectedGajiAkhir = 4000000 + (100 * 20000);
        $this->assertEquals($expectedGajiAkhir, $pegawai->hitungGajiAkhir());
    }
}
