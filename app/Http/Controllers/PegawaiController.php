<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawais = Pegawai::with('jabatan')->get();

        foreach ($pegawais as $pegawai) {
            $pegawai->gaji_akhir = $this->hitungGajiAkhir($pegawai);
        }

        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatans = Jabatan::all(); // Ambil semua data jabatan
        return view('pegawai.create', compact('jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:pegawai|max:8',
            'nama' => 'required|string|max:255',
            'tahun_masuk' => 'required|integer|min:2000|max:' . date('Y'),
            'gaji_pokok' => 'required|numeric|min:0',
            'jabatan_id' => 'required|exists:jabatan,id',
            'jam_lembur' => 'nullable|numeric|min:0',
            'jumlah_pelanggan' => 'nullable|integer|min:0',
            'peningkatan_penjualan' => 'nullable|integer|min:0|max:100',
        ]);

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $jabatans = Jabatan::all();
        return view('pegawai.edit', compact('pegawai', 'jabatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nip' => 'required|max:8|unique:pegawai,nip,' . $pegawai->id,
            'nama' => 'required|string|max:255',
            'tahun_masuk' => 'required|integer|min:2000|max:' . date('Y'),
            'gaji_pokok' => 'required|numeric|min:0',
            'jabatan_id' => 'required|exists:jabatan,id',
            'jam_lembur' => 'nullable|numeric|min:0',
            'jumlah_pelanggan' => 'nullable|integer|min:0',
            'peningkatan_penjualan' => 'nullable|numeric|min:0|max:100',
        ]);

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }

    private function hitungGajiAkhir(Pegawai $pegawai)
    {
        $gaji_pokok = $pegawai->gaji_pokok ?? 0;
        $jam_lembur = $pegawai->jam_lembur ?? 0;
        $jumlah_pelanggan = $pegawai->jumlah_pelanggan ?? 0;
        $tahun_masuk = $pegawai->tahun_masuk ?? date('Y');
        $peningkatan_penjualan = $pegawai->peningkatan_penjualan ?? 0;

        $gaji_akhir = $gaji_pokok;

        if (!isset($pegawai->jabatan->nama)) {
            throw new \Exception('Jabatan is not set or invalid.');
        }

        switch ($pegawai->jabatan->nama) {
            case 'Satpam':
                if ($jam_lembur < 0) {
                    throw new \Exception('Jam lembur tidak valid.');
                }
                $gaji_akhir += $jam_lembur * 20000;
                break;

            case 'Sales':
                if ($pegawai->jabatan->nama === 'Sales' && $jumlah_pelanggan <= 0) {
                    throw new \Exception('Jumlah pelanggan tidak valid.');
                }
                $gaji_akhir += $jumlah_pelanggan * 50000;
                break;

            case 'Administrasi':
                $lama_kerja = date('Y') - $tahun_masuk;
                $tunjangan = 0;
                if ($lama_kerja >= 5) {
                    $tunjangan = $gaji_pokok * 0.03;
                } elseif ($lama_kerja >= 3) {
                    $tunjangan = $gaji_pokok * 0.01;
                }
                $gaji_akhir += $tunjangan;
                break;

            case 'Manajer':
                $bonus = 0;
                if ($peningkatan_penjualan > 10) {
                    $bonus = $gaji_pokok * 0.10;
                } elseif ($peningkatan_penjualan >= 6) {
                    $bonus = $gaji_pokok * 0.05;
                } elseif ($peningkatan_penjualan >= 1) {
                    $bonus = $gaji_pokok * 0.02;
                }
                $gaji_akhir += $bonus;
                break;
        }

        return $gaji_akhir;
    }

    public function testHitungGajiAkhir(Pegawai $pegawai)
    {
        return $this->hitungGajiAkhir($pegawai); // Memanggil private method
    }
}
