@extends('layouts.main')
@section('title', 'Evaluasi Supplier')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Evaluasi Supplier</h4>

                {{-- FIX BOOTSTRAP 5 --}}
                <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addEvaluationModal">
                    <i class="fas fa-plus"></i> Tambah Evaluasi
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Supplier</th>
                                <th>Request</th>
                                <th>Score</th>
                                <th>Catatan</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evaluations as $index => $evaluation)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $evaluation->supplier->name }}</td>
                                <td>#{{ $evaluation->procrumentRequest->code }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $evaluation->score }}</span>
                                </td>
                                <td>{{ $evaluation->note ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editEvaluationModal{{ $evaluation->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
    
                                        <form action="{{ route('supplier_evaluation.destroy', $evaluation->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL ADD ================= --}}
<div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('supplier_evaluation.store') }}" method="POST" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Evaluasi Supplier</h5>

                {{-- FIX CLOSE BUTTON --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Procrument Request</label>
                    <select name="procrument_request_id" class="form-select" required>
                        <option value="">-- Pilih Request --</option>
                        @foreach ($requests as $req)
                            <option value="{{ $req->id }}">#{{ $req->code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Score (1–100)</label>
                    <input type="number" name="score" class="form-control" min="1" max="100" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
@foreach ($evaluations as $evaluation)
<div class="modal fade" id="editEvaluationModal{{ $evaluation->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('supplier_evaluation.update', $evaluation->id) }}"
            method="POST" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Evaluasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Score</label>
                    <input type="number" name="score"
                        class="form-control"
                        value="{{ $evaluation->score }}"
                        min="1" max="100" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="note" class="form-control" rows="3">{{ $evaluation->note }}</textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-info">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-delete', function () {
    let form = $(this).closest('form');
    Swal.fire({
        title: 'Hapus Evaluasi?',
        text: 'Data tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>
@endpush
