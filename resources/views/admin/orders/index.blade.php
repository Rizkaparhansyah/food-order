@extends('admin.layouts.app')

@section('content')
<div class="container mt-3">
    <h1 class="mb-3">Daftar Pesanan</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->nama_pelanggan }}</td>
                <td>{{ $order->menu->nama ?? 'N/A' }}</td> <!-- Display menu name -->
                <td>{{ $order->jumlah }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
        @endforeach
        
        </tbody>
    </table>
</div>
@endsection
