@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Daftar Pegawai</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('message'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <a class="btn btn-primary" href="{{ route('pegawai.create') }}">Tambah Pegawai</a>
        <table class="mt-4 table">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Gaji Pokok</th>
                    <th>Gaji Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawais as $pegawai)
                    <tr>
                        <td>{{ $pegawai->nip }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        <td>{{ $pegawai->jabatan->nama }}</td>
                        <td>Rp {{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($pegawai->gaji_akhir, 0, ',', '.') }}</td>
                        <td class="d-flex justify-center gap-2"><a class="btn btn-warning"
                                href="{{ route('pegawai.edit', $pegawai) }}">Edit</a>
                            <form action="{{ route('pegawai.destroy', $pegawai) }}" method="POST">@csrf @method('delete')
                                <button class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
