<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pegawai::create([
            'nip' => 'SP001',
            'nama' => 'Budi Santoso',
            'tahun_masuk' => 2020,
            'gaji_pokok' => 3000000,
            'jabatan_id' => 1, // Satpam
            'jam_lembur' => 10,
            'jumlah_pelanggan' => null,
            'peningkatan_penjualan' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Pegawai::create([
            'nip' => 'SA002',
            'nama' => 'Ani Wijaya',
            'tahun_masuk' => 2018,
            'gaji_pokok' => 4000000,
            'jabatan_id' => 2, // Sales
            'jam_lembur' => null,
            'jumlah_pelanggan' => 15,
            'peningkatan_penjualan' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Pegawai::create([
            'nip' => 'AD003',
            'nama' => 'Citra Dewi',
            'tahun_masuk' => 2015,
            'gaji_pokok' => 3500000,
            'jabatan_id' => 3, // Administrasi
            'jam_lembur' => null,
            'jumlah_pelanggan' => null,
            'peningkatan_penjualan' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Pegawai::create([
            'nip' => 'MN004',
            'nama' => 'Dian Pratama',
            'tahun_masuk' => 2012,
            'gaji_pokok' => 5000000,
            'jabatan_id' => 4, // Manajer
            'jam_lembur' => null,
            'jumlah_pelanggan' => null,
            'peningkatan_penjualan' => 12,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Pegawai::create([
            'nip' => 'MN005',
            'nama' => 'Apip Basuri',
            'tahun_masuk' => 2024,
            'gaji_pokok' => 30000000,
            'jabatan_id' => 2, // Sales
            'jam_lembur' => null,
            'jumlah_pelanggan' => null,
            'peningkatan_penjualan' => 12,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
