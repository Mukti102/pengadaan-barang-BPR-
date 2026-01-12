@extends('layouts.main')
@section('title', 'Edit Pengajuan Pengadaan')
@section('description', 'Perbarui data pengajuan pengadaan barang.')
@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- Pastikan route merujuk ke update dan menyertakan ID --}}
        <form action="{{ route('procrument-request.update', $procrumentRequest->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Pengadaan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Pengajuan</label>
                                <input type="text" name="code" class="form-control" value="{{ $procrumentRequest->code }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="date" class="form-control" value="{{ $procrumentRequest->date }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Item Barang</h4>
                    <button type="button" class="btn btn-primary btn-sm" id="add-item">
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="items-table">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th width="110">Qty</th>
                                    <th width="150">Satuan (Unit)</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                    <th width="50">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="item-container">
                                @foreach($procrumentRequest->items as $index => $item)
                                <tr class="item-row">
                                    <td><input type="text" name="items[{{ $index }}][name]" class="form-control" value="{{ $item->name }}" required></td>
                                    <td><input type="number" name="items[{{ $index }}][quantity]" class="form-control qty" value="{{ $item->quantity }}" min="1" required></td>
                                    <td><input type="text" name="items[{{ $index }}][unit]" class="form-control" value="{{ $item->unit }}" placeholder="Pcs/Box"></td>
                                    <td><input type="number" name="items[{{ $index }}][price]" class="form-control price" value="{{ $item->price }}" min="0" required></td>
                                    <td><input type="number" name="items[{{ $index }}][subtotal]" class="form-control subtotal" value="{{ $item->subtotal }}" readonly></td>
                                    <td>
                                        @if($index > 0)
                                            <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total Keseluruhan:</th>
                                    <th>
                                        <input type="number" name="total_amount" id="total_amount" class="form-control" value="{{ $procrumentRequest->total_amount }}" readonly>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('procrument-request.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui Pengajuan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        // Inisialisasi index berdasarkan jumlah item yang ada
        let rowIdx = {{ $procrumentRequest->items->count() }};

        // Tambah Baris Baru
        $('#add-item').on('click', function() {
            let newRow = `
            <tr class="item-row">
                <td><input type="text" name="items[${rowIdx}][name]" class="form-control" required></td>
                <td><input type="number" name="items[${rowIdx}][quantity]" class="form-control qty" min="1" required></td>
                <td><input type="text" name="items[${rowIdx}][unit]" class="form-control"></td>
                <td><input type="number" name="items[${rowIdx}][price]" class="form-control price" min="0" required></td>
                <td><input type="number" name="items[${rowIdx}][subtotal]" class="form-control subtotal" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
            </tr>`;
            $('#item-container').append(newRow);
            rowIdx++;
        });

        // Hapus Baris
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            calculateTotal();
        });

        // Hitung Subtotal dan Total
        $(document).on('input', '.qty, .price', function() {
            let row = $(this).closest('tr');
            let qty = parseFloat(row.find('.qty').val()) || 0;
            let price = parseFloat(row.find('.price').val()) || 0;
            let subtotal = qty * price;
            row.find('.subtotal').val(subtotal);
            calculateTotal();
        });

        function calculateTotal() {
            let total = 0;
            $('.subtotal').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('#total_amount').val(total);
        }
    </script>
@endpush

@endsection