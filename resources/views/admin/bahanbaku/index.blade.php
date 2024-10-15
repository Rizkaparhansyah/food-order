@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Kelola Bahan Baku</h1>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                <th>Aksi</th>
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
                    <td>
                        <a href="{{ route('admin.bahanbaku.edit', $bahan->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.bahanbaku.destroy', $bahan->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>        
    </table>

    <!-- Form Tambah Jenis Bahan Baku -->
    <form action="{{ route('admin.bahanbaku.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="jenis">Jenis Bahan Baku</label>
            <input type="text" name="jenis" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="subkategori">Subkategori</label>
            <input type="text" name="subkategori" class="form-control">
        </div>
        <div class="form-group">
            <label for="penggunaan">Penggunaan Bahan Baku</label>
            <input type="text" name="penggunaan" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="khusus">Digunakan untuk Acara Khusus</label>
            <input type="checkbox" name="khusus" value="1">
        </div>
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>       
        <button type="submit" class="btn btn-primary">Tambah Bahan Baku</button>
    </form>
</div>
@endsection
