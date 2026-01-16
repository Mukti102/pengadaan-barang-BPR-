@extends('layouts.main')
@section('title', 'Pengajuan Pengadaan')
@section('description', 'Buat Pengajuan Pengadaan, Harap Isi data dengan Benar')
@section('content')
    @php use Illuminate\Support\Facades\Crypt; @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="card-title mb-0">Data Pengajuan Pengadaan</h1>
                    <div class="d-flex gap-2">
                        <a href="{{ route('procrument-request.create') }}" class="btn btn-sm btn-primary">
                            + Buat Pengajuan Pengadaan
                        </a>
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('procrument.print') }}" class="btn btn-sm btn-warning">
                                Cetak
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($procruments as $procrument)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $procrument->code }}</td>
                                        <td>{{ $procrument->user->name ?? '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($procrument->date)->translatedFormat('d F Y') }}</td>
                                        <td>{{ rupiah($procrument->total_amount) ?? '' }}</td>
                                        <td>
                                            <span
                                                class="badge 
    @if ($procrument->status == 'pending') bg-warning
    @elseif($procrument->status == 'disetujui')
        bg-success
    @elseif($procrument->status == 'ditolak')
        bg-danger
    @else
        bg-secondary @endif
">
                                                {{ ucfirst($procrument->status) }}
                                            </span>

                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('procrument.cetak', $procrument->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                <a href="{{ route('procrument-request.show', $procrument->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('procrument-request.edit', $procrument->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>

                                                </a>
                                                <button type="button" class="btn btn-sm  btn-danger btn-delete"
                                                    data-url="{{ route('procrument-request.destroy', $procrument->id) }}"
                                                    data-name="{{ $procrument->name }}">
                                                    <i class="fas fa-trash"></i>

                                                </button>
                                            </div>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No data</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
