@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard Overview</h3>
            <h6 class="op-7 mb-2">Selamat Datang kembali, <strong>{{ Auth::user()->name }}</strong> ({{ ucfirst($data['role']) }})</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            @if ($data['role'] == 'staff')
                <a href="{{ route('procrument-request.create') }}" class="btn btn-primary btn-round">Buat Pengajuan Baru</a>
            @endif
        </div>
    </div>

    <div class="row">
        {{-- WIDGET KHUSUS ADMIN --}}
        @if ($data['role'] == 'admin')
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small"><i class="fas fa-users"></i></div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total User</p>
                                    <h4 class="card-title">{{ $data['total_users'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- WIDGET KHUSUS PIMPINAN --}}
        @if ($data['role'] == 'pimpinan')
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small"><i class="fas fa-exclamation-circle"></i></div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Butuh Approval</p>
                                    <h4 class="card-title">{{ $data['pending_approvals'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small"><i class="fas fa-wallet"></i></div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Anggaran</p>
                                    <h4 class="card-title">Rp {{ number_format($data['total_budget'], 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- WIDGET UMUM (PENGADAAN) --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small"><i class="fas fa-file-invoice"></i></div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ $data['role'] == 'staff' ? 'Pengajuan Saya' : 'Total Pengajuan' }}</p>
                                <h4 class="card-title">{{ $data['requests']->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- WIDGET ADMIN SELESAI --}}
        @if ($data['role'] == 'admin')
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body text-center">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small"><i class="fas fa-truck-loading"></i></div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0 text-start">
                                <p class="card-category">Supplier</p>
                                <h4 class="card-title">{{ $data['total_suppliers'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        {{-- TABEL PENGADAAN (Dilihat Semua Role, tapi isinya disaring di Controller) --}}
        <div class="col-md-{{ $data['role'] == 'admin' ? '8' : '12' }}">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Aktivitas Pengajuan Terakhir</div>
                        <div class="card-tools">
                            <a href="{{ route('procrument-request.index') }}" class="btn btn-label-info btn-round btn-sm">
                                <span class="btn-label"><i class="fa fa-eye"></i></span> Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Kode</th>
                                    @if($data['role'] != 'staff') <th>Pemohon</th> @endif
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['requests']->take(5) as $req)
                                    <tr>
                                        <td><strong>{{ $req->code }}</strong></td>
                                        @if($data['role'] != 'staff') <td>{{ $req->user->name ?? '-' }}</td> @endif
                                        <td>{{ \Carbon\Carbon::parse($req->request_date)->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($req->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $req->status == 'disetujui' ? 'success' : ($req->status == 'menunggu' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">Belum ada data pengajuan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL SAMPING HANYA UNTUK ADMIN --}}
        @if ($data['role'] == 'admin')
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-body">
                    <div class="card-title fw-mediumbold">Top Suppliers</div>
                    <div class="card-list">
                        @foreach ($data['suppliers'] as $sup)
                            <div class="item-list">
                                <div class="info-user ms-3">
                                    <div class="username">{{ $sup->name }}</div>
                                    <div class="status text-muted small">{{ $sup->email }}</div>
                                </div>
                                <a href="tel:{{ $sup->phone }}" class="btn btn-icon btn-primary btn-round btn-xs">
                                    <i class="fa fa-phone"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection