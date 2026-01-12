@extends('layouts.main')
@section('title', 'Profile')
@section('content')

    <div class="row">

        {{-- Edit Profile --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Update Profile</strong>
                </div>

                <div class="card-body">

                    @if (session('profile_updated'))
                        <div class="alert alert-success">{{ session('profile_updated') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telephone</label>
                            <input type="number" placeholder="08****" name="phone" class="form-control"
                                value="{{ $user->phone }}">
                        </div>

                        <button class="btn btn-primary">Simpan Perubahan</button>
                    </form>

                </div>
            </div>
        </div>


        {{-- Ubah Password --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Ubah Password</strong>
                </div>

                <div class="card-body">

                    @if (session('password_changed'))
                        <div class="alert alert-success">{{ session('password_changed') }}</div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Password Sekarang</label>
                            <input type="password" class="form-control" name="current_password" required>
                            @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <button class="btn btn-warning">Update Password</button>
                    </form>

                </div>
            </div>
        </div>


        {{-- Delete Account --}}
        <div class="col-md-12">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <strong>Delete Account</strong>
                </div>

                <div class="card-body">

                    <p>Jika Anda menghapus akun, semua data akan hilang permanen.</p>

                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('Apakah anda yakin ingin menghapus akun?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger">Hapus Akun</button>
                    </form>

                </div>
            </div>
        </div>

    </div>


@endsection
