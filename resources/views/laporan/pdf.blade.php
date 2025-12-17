<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-aktif {
            color: green;
        }
        .status-terlambat {
            color: red;
        }
        .footer {
            text-align: right;
            font-size: 10px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMINJAMAN BARANG</h1>
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 20%">Peminjam</th>
                <th style="width: 10%">Role</th>
                <th style="width: 20%">Barang</th>
                <th style="width: 15%">Tgl Pinjam</th>
                <th style="width: 15%">Tgl Kembali</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ $item->peminjam_nama }}<br>
                    <small>{{ $item->identitas }}</small>
                </td>
                <td>{{ ucfirst($item->role) }}</td>
                <td>
                    {{ $item->barang_nama }}<br>
                    <small>{{ $item->kode_barang }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                <td>
                    @php
                        $today = \Carbon\Carbon::now();
                        $returnDate = \Carbon\Carbon::parse($item->tanggal_kembali);
                    @endphp
                    @if($returnDate->lt($today))
                        <span class="status-terlambat">Terlambat</span>
                    @else
                        <span class="status-aktif">Aktif</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh sistem.</p>
    </div>
</body>
</html>
