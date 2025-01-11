@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Edit Pegawai</h1>
        <form method="POST" action="{{ route('pegawai.update', $pegawai) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" id="nip" class="form-control" maxlength="8"
                    value="{{ $pegawai->nip }}" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $pegawai->nama }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                <input type="number" name="tahun_masuk" id="tahun_masuk" class="form-control" min="2000"
                    max="{{ date('Y') }}" value="{{ $pegawai->tahun_masuk }}" required>
            </div>
            <div class="mb-3">
                <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" min="0" step="0.01"
                    value="{{ $pegawai->gaji_pokok }}" required>
            </div>
            <div class="mb-3">
                <label for="jabatan_id" class="form-label">Jabatan</label>
                <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                    @foreach ($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}" @if ($pegawai->jabatan_id == $jabatan->id) selected @endif>
                            {{ $jabatan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="jam_lembur" class="form-label">Jam Lembur</label>
                <input type="number" name="jam_lembur" id="jam_lembur" class="form-control" min="0"
                    value="{{ $pegawai->jam_lembur }}">
            </div>
            <div class="mb-3">
                <label for="jumlah_pelanggan" class="form-label">Jumlah Pelanggan</label>
                <input type="number" name="jumlah_pelanggan" id="jumlah_pelanggan" class="form-control" min="0"
                    value="{{ $pegawai->jumlah_pelanggan }}">
            </div>
            <div class="mb-3">
                <label for="peningkatan_penjualan" class="form-label">Peningkatan Penjualan (%)</label>
                <input type="number" name="peningkatan_penjualan" id="peningkatan_penjualan" class="form-control"
                    min="0" max="100" step="0.01" value="{{ $pegawai->peningkatan_penjualan }}">
            </div>
            <button type="submit" class="btn btn-light px-5 shadow-sm stroke h-100">Update</button>
        </form>
    </div>
@endsection
