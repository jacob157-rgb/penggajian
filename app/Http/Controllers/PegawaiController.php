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
        $gaji_akhir = $pegawai->gaji_pokok;

        switch ($pegawai->jabatan->nama) {
            case 'Satpam':
                $gaji_akhir += $pegawai->jam_lembur * 20000;
                break;

            case 'Sales':
                $gaji_akhir += $pegawai->jumlah_pelanggan * 50000;
                break;

            case 'Administrasi':
                $lama_kerja = date('Y') - $pegawai->tahun_masuk;
                $tunjangan = 0;
                if ($lama_kerja >= 5) {
                    $tunjangan = $pegawai->gaji_pokok * 0.03;
                } elseif ($lama_kerja >= 3) {
                    $tunjangan = $pegawai->gaji_pokok * 0.01;
                }
                $gaji_akhir += $tunjangan;
                break;

            case 'Manajer':
                if ($pegawai->peningkatan_penjualan > 10) {
                    $bonus = $pegawai->gaji_pokok * 0.10;
                } elseif ($pegawai->peningkatan_penjualan >= 6) {
                    $bonus = $pegawai->gaji_pokok * 0.05;
                } elseif ($pegawai->peningkatan_penjualan >= 1) {
                    $bonus = $pegawai->gaji_pokok * 0.02;
                } else {
                    $bonus = 0;
                }
                $gaji_akhir += $bonus;
                break;
        }

        return $gaji_akhir;
    }
}
