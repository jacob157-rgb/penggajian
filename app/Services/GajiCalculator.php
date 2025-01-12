<?php

namespace App\Services;

use App\Contracts\GajiCalculatorInterface;
use App\Models\Pegawai;

class GajiCalculator implements GajiCalculatorInterface
{
    protected $pegawai;

    public function __construct(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai;
    }

    public function hitungGajiAkhir()
    {
        $gaji_akhir = $this->pegawai->gaji_pokok;

        switch ($this->pegawai->jabatan->nama) {
            case 'Satpam':
                $gaji_akhir += $this->pegawai->jam_lembur * 20000;
                break;

            case 'Sales':
                $gaji_akhir += $this->pegawai->jumlah_pelanggan * 50000;
                break;

            case 'Administrasi':
                $lama_kerja = date('Y') - $this->pegawai->tahun_masuk;
                $tunjangan = 0;
                if ($lama_kerja >= 5) {
                    $tunjangan = $this->pegawai->gaji_pokok * 0.03;
                } elseif ($lama_kerja >= 3) {
                    $tunjangan = $this->pegawai->gaji_pokok * 0.01;
                }
                $gaji_akhir += $tunjangan;
                break;

            case 'Manajer':
                if ($this->pegawai->peningkatan_penjualan > 10) {
                    $bonus = $this->pegawai->gaji_pokok * 0.10;
                } elseif ($this->pegawai->peningkatan_penjualan >= 6) {
                    $bonus = $this->pegawai->gaji_pokok * 0.05;
                } elseif ($this->pegawai->peningkatan_penjualan >= 1) {
                    $bonus = $this->pegawai->gaji_pokok * 0.02;
                } else {
                    $bonus = 0;
                }
                $gaji_akhir += $bonus;
                break;
        }

        return $gaji_akhir;
    }
}
