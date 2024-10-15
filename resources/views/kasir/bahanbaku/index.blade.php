@extends('kasir.layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Bahan Baku</h1>

    <!-- Tabel Jenis dan Penggunaan Bahan Baku -->
    <h2>Daftar Jenis dan Penggunaan Bahan Baku</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Bahan Baku</th>
                <th>Subkategori</th>
                <th>Penggunaan Bahan Baku</th>
                <th>Khusus</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bahanBaku as $index => $bahan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bahan->jenis }}</td>
                    <td>{{ $bahan->subkategori ?? 'Tidak ada subkategori' }}</td>
                    <td>{{ $bahan->penggunaan }}</td>
                    <td>{{ $bahan->khusus ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $bahan->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
