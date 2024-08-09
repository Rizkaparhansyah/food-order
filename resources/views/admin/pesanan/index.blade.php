@extends('admin.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container mt-3">
    <h1 class="mb-4">Daftar Pesanan</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>ID Menu</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Waktu Pemesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $pesanan)
                <tr>
                    <td>{{ $pesanan->id }}</td>
                    <td>{{ $pesanan->nama_pelanggan }}</td>
                    <td>{{ $pesanan->id_menu }}</td>
                    <td>{{ $pesanan->jumlah }}</td>
                    <td>{{ $pesanan->status }}</td>
                    <td>{{ $pesanan->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
