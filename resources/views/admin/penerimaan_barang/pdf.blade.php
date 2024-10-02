<!DOCTYPE html>
<html>
<head>
    <title>Penerimaan Barang - {{ $Penerimaan_Barang->id }}</title>
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
        <h1>PENERIMAAN BARANG</h1>
        <p>Nomor Dokumen: {{ $Penerimaan_Barang->id }}</p>
    </div>

    <table>
        <tr>
            <th>Nama Barang/Bahan Baku</th>
            <td>{{ $Penerimaan_Barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Jumlah Diterima</th>
            <td>{{ $Penerimaan_Barang->jumlah }} Unit</td>
        </tr>
        <tr>
            <th>Harga Satuan</th>
            <td>Rp. {{ number_format($Penerimaan_Barang->harga_satuan, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>Rp. {{ number_format($Penerimaan_Barang->total_harga, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Tanggal Penerimaan</th>
            <td>{{ \Carbon\Carbon::parse($Penerimaan_Barang->tanggal_penerimaan)->format('d-m-Y') }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Nama Pemasok</th>
            <td>{{ $Penerimaan_Barang->nama_pemasok }}</td>
        </tr>
        <tr>
            <th>Nomor Faktur</th>
            <td>{{ $Penerimaan_Barang->nomor_faktur }}</td>
        </tr>
    </table>

    {{-- <div class="signature">
        <p>Yang Menerima,</p>
        <br><br><br>
        <p>________________________</p>
    </div> --}}
</body>
</html>
