@extends('layouts.main')
@section('title', 'Detail Pengajuan Pengadaan')
@section('description', 'Informasi rinci mengenai pengajuan kode: ' . $procrumentRequest->code)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('procrument-request.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            @if ($procrumentRequest->status == 'ditolak')
                <div class="card card-danger shadow-sm mb-4">
                    <div class="card-header bg-danger text-white">
                        <h4><i class="fas fa-exclamation-circle"></i> Alasan Penolakan</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><strong>Catatan:</strong></p>
                        <blockquote class="blockquote mb-0 mt-2">
                            <p class="text-white italic">"{{ $procrumentRequest->approvals->note ?? 'Tidak ada catatan alasan.' }}"
                            </p>
                        </blockquote>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Informasi Header</h4>
                    <div>
                        @if ($procrumentRequest->status == 'menunggu')
                            <span class="badge badge-warning text-dark">Menunggu Persetujuan</span>
                        @elseif($procrumentRequest->status == 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="font-weight-bold">Kode Pengajuan</label>
                            <p>{{ $procrumentRequest->code }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="font-weight-bold">Tanggal Pengajuan</label>
                            <p>{{ \Carbon\Carbon::parse($procrumentRequest->date)->format('d F Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="font-weight-bold">Diajukan Oleh</label>
                            <p>{{ $procrumentRequest->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4>Daftar Barang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Barang</th>
                                    <th class="text-center">Jumlah (Qty)</th>
                                    <th>Satuan</th>
                                    <th class="text-right">Harga Satuan</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($procrumentRequest->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td>{{ $item->unit ?? '-' }}</td>
                                        <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Total Keseluruhan</th>
                                    <th class="text-right bg-yellow">
                                        <strong>Rp
                                            {{ number_format($procrumentRequest->total_amount, 0, ',', '.') }}</strong>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @if ($procrumentRequest->status == 'menunggu')
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-success"
                            onclick="confirmApprove({{ $procrumentRequest->id }})">
                            Setujui
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            Tolak
                        </button>

                    </div>

                    <form id="approve-form-{{ $procrumentRequest->id }}"
                        action="{{ route('procurement.approve', $procrumentRequest->id) }}" method="POST"
                        style="display: none;">
                        @csrf @method('PATCH')
                    </form>
                @endif
                @if ($procrumentRequest->status == 'menunggu')
                    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog"
                        aria-labelledby="rejectModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('procurement.reject', $procrumentRequest->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-left">
                                        <div class="form-group">
                                            <label>Berikan alasan mengapa pengajuan ini ditolak:</label>
                                            <textarea name="reason" class="form-control" rows="4" required placeholder="Contoh: Anggaran tidak mencukupi."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Kirim & Tolak</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Fungsi Konfirmasi Setuju
        function confirmApprove(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pengajuan ini akan disetujui!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-form-' + id).submit();
                }
            })
        }

        // Alert Sukses/Gagal (Jika ada session flash)
        @if (session('success'))
            Swal.fire('Berhasil!', "{{ session('success') }}", 'success');
        @endif
    </script>
@endpush
