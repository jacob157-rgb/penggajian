@extends('layouts.auth')

@section('auth')
    <div class="container">
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
        <h1>Login</h1>

        <form action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Masukan email" required>
            </div>
            <div class="form-group mt-2">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Masukan Password" required>
            </div>
            <button type="submit" class="btn btn-dark mt-3 px-5 shadow-sm">Masuk</button>
            <a href="{{ route('register.form') }}" class="btn btn-dark mt-3 px-5 shadow-sm">Daftar</a>
        </form>
    </div>
@endsection
