<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengadaan - {{ $procrument->code }}</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Header Style */
        .header-container {
            width: 100%;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #1a508b; /* Blue accent */
            text-transform: uppercase;
            margin: 0;
        }
        .report-title {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
            letter-spacing: 1px;
        }

        /* Info Section */
        .info-section {
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        .label {
            color: #777;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            width: 150px;
        }
        .value {
            font-weight: bold;
            color: #111;
        }

        /* Status Badge */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            text-transform: uppercase;
            color: white;
        }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #333; }
        .bg-danger { background-color: #dc3545; }

        /* Table Styling */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.main-table th {
            background-color: #f8f9fa;
            color: #1a508b;
            text-align: left;
            padding: 12px 10px;
            border-bottom: 2px solid #1a508b;
            font-size: 11px;
            text-transform: uppercase;
        }
        table.main-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Totals */
        .total-row td {
            padding-top: 20px !important;
            border-bottom: none !important;
        }
        .total-box {
            background-color: #1a508b;
            color: #fff;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        /* Reason/Note Box */
        .note-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff4f4;
            border-left: 4px solid #dc3545;
        }
        .note-title {
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 5px;
        }

        /* Signature Area */
        .footer-sign {
            margin-top: 50px;
            width: 100%;
        }
        .sign-col {
            width: 40%;
            text-align: center;
            float: right;
        }
        .sign-space {
            height: 80px;
        }
        .sign-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <table class="header-container">
        <tr>
            <td style="width: 50%;">
                <h1 class="company-name">{{ setting('site_name', 'COMPANY NAME') }}</h1>
                <div class="report-title">LAPORAN PERMINTAAN PENGADAAN</div>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: bottom; color: #999;">
                Dicetak pada: {{ date('d/m/Y H:i') }}
            </td>
        </tr>
    </table>

    {{-- INFO --}}
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">No. Dokumen</td>
                <td class="value">: {{ $procrument->code }}</td>
                <td class="label">Diajukan Oleh</td>
                <td class="value">: {{ $procrument->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="value">: {{ \Carbon\Carbon::parse($procrument->request_date)->format('d F Y') }}</td>
                <td class="label">Status</td>
                <td class="value">: 
                    <span class="badge {{ $procrument->status == 'disetujui' ? 'bg-success' : ($procrument->status == 'menunggu' ? 'bg-warning' : 'bg-danger') }}">
                        {{ $procrument->status }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    {{-- REASON IF REJECTED --}}
    @if($procrument->status == 'ditolak')
    <div class="note-box">
        <div class="note-title">Alasan Penolakan:</div>
        <div>{{ $procrument->note }}</div>
    </div>
    @endif

    {{-- ITEM TABLE --}}
    <table class="main-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th>Deskripsi Barang</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="10%" class="text-center">Unit</th>
                <th width="20%" class="text-right">Harga Satuan</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($procrument->items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td style="font-weight: bold;">{{ $item->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-center">{{ $item->unit }}</td>
                    <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada item barang</td>
                </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="4"></td>
                <td class="text-right" style="vertical-align: middle; font-weight: bold;">TOTAL KESELURUHAN</td>
                <td class="text-right">
                    <div class="total-box">
                        Rp {{ number_format($procrument->total_amount, 0, ',', '.') }}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer-sign">
        <div class="sign-col">
            <p>Disetujui oleh,</p>
            <div class="sign-space"></div>
            <p class="sign-name">( ____________________ )</p>
            <p style="font-size: 10px; color: #777;">Pimpinan / Manajer</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>