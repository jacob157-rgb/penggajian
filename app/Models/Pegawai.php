<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiBase extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $guarded = ['id'];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}

class Pegawai extends PegawaiBase
{
    // Tambahan atau modifikasi sifat kelas di sini
    public function hitungGajiAkhir()
    {
        $gaji_akhir = $this->gaji_pokok;

        switch ($this->jabatan->nama) {
            case 'Satpam':
                $gaji_akhir += $this->jam_lembur * 20000;
                break;

            case 'Sales':
                $gaji_akhir += $this->jumlah_pelanggan * 50000;
                break;

            case 'Administrasi':
                $lama_kerja = date('Y') - $this->tahun_masuk;
                $tunjangan = $lama_kerja >= 5 ? $this->gaji_pokok * 0.03 : ($lama_kerja >= 3 ? $this->gaji_pokok * 0.01 : 0);
                $gaji_akhir += $tunjangan;
                break;

            case 'Manajer':
                $bonus = $this->peningkatan_penjualan > 10 ? $this->gaji_pokok * 0.10 : ($this->peningkatan_penjualan >= 6 ? $this->gaji_pokok * 0.05 : ($this->peningkatan_penjualan >= 1 ? $this->gaji_pokok * 0.02 : 0));
                $gaji_akhir += $bonus;
                break;
        }

        return $gaji_akhir;
    }

    // Overloading menggunakan magic method __call
    public function __call($name, $arguments)
    {
        // Hanya tangani metode khusus 'hitung'
        if ($name === 'hitung') {
            switch (count($arguments)) {
                case 1:
                    return $this->hitungBonus($arguments[0]);
                case 2:
                    return $this->hitungGaji($arguments[0], $arguments[1]);
            }
        }

        // Jika bukan metode 'hitung', delegasikan ke parent class
        return parent::__call($name, $arguments);
    }



    private function hitungBonus($penjualan)
    {
        return $penjualan * 0.10;
    }

    private function hitungGaji($gajiPokok, $lembur)
    {
        return $gajiPokok + ($lembur * 20000);
    }
}
