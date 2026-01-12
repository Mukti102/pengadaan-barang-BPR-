@extends('layouts.main')
@section('title', 'Pengaturan')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Pengaturan Website</h5>
        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Site Name --}}
                <div class="mb-3">
                    <label class="form-label">Nama Website</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="form-control"
                        placeholder="Contoh: My Kost App">
                </div>

                {{-- WhatsApp --}}
                <div class="mb-3">
                    <label class="form-label">No WhatsApp (628)</label>
                    <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" class="form-control"
                        placeholder="628xxxxxx">
                </div>

                {{-- email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $settings['email'] ?? '' }}" class="form-control"
                        placeholder="Example@gmail.com">
                </div>

                {{-- Address --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="3">{{ $settings['address'] ?? '' }}</textarea>
                </div>

                {{-- Logo --}}
                <div class="mb-3">
                    <label class="form-label">Logo Website</label>
                    <input type="file" name="logo" class="form-control">

                    @if (isset($settings['site_logo']))
                        <small class="d-block mt-2">Preview Logo:</small>
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="img-thumbnail mt-2" width="120">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>

        </div>
    </div>
@endsection
