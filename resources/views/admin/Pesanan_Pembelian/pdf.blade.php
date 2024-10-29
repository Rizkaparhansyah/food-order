<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Pembelian - {{ $pesanan->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pesanan Pembelian</h1>
        <p>No. Pesanan: {{ $pesanan->id }}</p>
    </div>
    <table>
        <tr>
            <th>Nama Pemasok</th>
            <td>{{ $pesanan->nama_pemasok }}</td>
        </tr>
        <tr>
            <th>Tanggal Pesan</th>
            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $pesanan->nama_barang }}</td>
        </tr>
        <tr>
            <th>Harga Satuan</th>
            <td>Rp. {{ number_format($pesanan->harga_satuan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>Rp. {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>
    {{-- <div class="signature">
        <p>Tanda Tangan: _____________________</p>
    </div> --}}
</body>
</html>
