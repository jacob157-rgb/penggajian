@extends('layouts.app')

@section('content')
    <div class="container mt-4">
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
        <div class="d-flex justify-content-between">
            <h3>Daftar Pegawai</h3>
            <div class="d-flex gap-3">
                <a class="btn btn-dark px-5 shadow-sm" href="{{ route('pegawai.create') }}">Tambah Pegawai</a>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button class="btn btn-danger stroke px-5 shadow-sm">Keluar</button>
                </form>
            </div>
        </div>
        <table class="table-hover mt-4 table border-none">
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
                        <td class="">{{ $pegawai->nip }}</td>
                        <td class="w-25">{{ $pegawai->nama }}</td>
                        <td class="w-25">{{ $pegawai->jabatan->nama }}</td>
                        <td class="w-25">Rp {{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="w-25">Rp {{ number_format($pegawai->gaji_akhir, 0, ',', '.') }}</td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-dark h-100" href="{{ route('pegawai.edit', $pegawai) }}">Edit</a>
                            <form action="{{ route('pegawai.destroy', $pegawai) }}" method="POST">@csrf @method('delete')
                                <button class="btn btn-light stroke px-5 shadow-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
