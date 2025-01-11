<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jabatan::create([
            'nama' => 'Satpam'
        ]);
        Jabatan::create([
            'nama' => 'Sales'
        ]);
        Jabatan::create([
            'nama' => 'Administrasi'
        ]);
        Jabatan::create([
            'nama' => 'Manajer'
        ]);
    }
}
