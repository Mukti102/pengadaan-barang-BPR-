<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengadaan Barang</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.5;
        }

        /* Kop Surat Style */
        .header {
            text-align: center;
            margin-bottom: 30px;
            color: #1a508b; /* Navy Blue dari tema Login */
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            border-bottom: 2px solid #1a508b;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
            color: #666;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th {
            background-color: #1a508b;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 10px;
            padding: 10px 8px;
            border: 1px solid #154273;
        }

        table td {
            padding: 8px;
            border-bottom: 1px solid #e0e0e0;
            border-left: 1px solid #f0f0f0;
            border-right: 1px solid #f0f0f0;
        }

        /* Alternating row colors */
        table tbody tr:nth-child(even) {
            background-color: #f9fbfd;
        }

        /* Badge Status Style */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            color: #fff;
            display: block;
            width: 70px;
            margin: 0 auto;
        }
        .status-disetujui { background-color: #28a745; }
        .status-menunggu { background-color: #ffc107; color: #000; }
        .status-ditolak { background-color: #dc3545; }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }

        /* Summary Section */
        .total-section {
            margin-top: 10px;
            float: right;
            width: 250px;
        }

        .total-box {
            background-color: #f2f7ff;
            padding: 10px;
            border: 1px solid #1a508b;
            border-radius: 5px;
        }

        /* Footer & Signature */
        .footer-wrapper {
            margin-top: 50px;
            width: 100%;
        }

        .signature {
            width: 200px;
            float: right;
            text-align: center;
        }

        .signature-space {
            height: 70px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Pengadaan Barang</h2>
        <p class="fw-bold">{{setting('site_name')}}</p>
        <p>{{setting('address')}}</p>
        <p>Tanggal Cetak: {{ now()->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Kode</th>
                <th>Pengaju</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Status</th>
                <th width="20%">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse ($procruments as $item)
                @php $grandTotal += $item->total_amount; @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $item->code }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->request_date)->format('d/m/Y') }}
                    </td>
                    <td>
                        <span class="badge status-{{ strtolower($item->status) }}">
                            {{ strtoupper($item->status) }}
                        </span>
                    </td>
                    <td class="text-right fw-bold">
                        {{ number_format($item->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Data tidak tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-box">
            <table style="margin-bottom: 0; border: none;">
                <tr>
                    <td style="border: none; padding: 2px;">Total Item:</td>
                    <td style="border: none; padding: 2px;" class="text-right fw-bold">{{ $procruments->count() }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 2px;">Grand Total:</td>
                    <td style="border: none; padding: 2px; font-size: 13px;" class="text-right fw-bold text-primary">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer-wrapper">
        <div class="signature">
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
            <p>Mengetahui,</p>
            <p class="fw-bold">Pimpinan</p>
            <div class="signature-space"></div>
            <p class="signature-name">( ____________________ )</p>
            <p>NIP. ............................</p>
        </div>
    </div>

</body>
</html>