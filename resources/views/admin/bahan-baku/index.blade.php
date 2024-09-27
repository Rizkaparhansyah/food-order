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

    <!-- Tabel Gabungan Jenis dan Penggunaan Bahan Baku -->
    <h2>Daftar Jenis dan Penggunaan Bahan Baku</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Bahan Baku</th>
                <th>Subkategori</th>
                <th>Penggunaan Bahan Baku</th>
                <th>Khusus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jenisBahanBaku as $index => $jenis)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $jenis->nama_jenis }}</td>
                    <td>
                        @if($jenis->subkategori->count() > 0)
                            <ul>
                                @foreach($jenis->subkategori as $subkategori)
                                    <li>{{ $subkategori->nama_subkategori }}</li>
                                @endforeach
                            </ul>
                        @else
                            <em>Tidak ada subkategori</em>
                        @endif
                    </td>
                    <!-- Ambil data penggunaan bahan baku sesuai indeks -->
                    @php
                        $penggunaan = $penggunaanBahanBaku->get($index);
                    @endphp
                    <td>{{ $penggunaan ? $penggunaan->nama_penggunaan : '-' }}</td>
                    <td>{{ $penggunaan && $penggunaan->khusus ? 'Ya' : 'Tidak' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Form Tambah Jenis Bahan Baku -->
    <form action="{{ route('bahan.baku.store.jenis') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_jenis">Jenis Bahan Baku</label>
            <input type="text" name="nama_jenis" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Jenis</button>
    </form>

    <!-- Form Tambah Subkategori Bahan Baku -->
    <form action="{{ route('bahan.baku.store.subkategori') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="jenis_bahan_baku_id">Jenis Bahan Baku</label>
            <select name="jenis_bahan_baku_id" class="form-control" required>
                @foreach($jenisBahanBaku as $jenis)
                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="nama_subkategori">Subkategori</label>
            <input type="text" name="nama_subkategori" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Subkategori</button>
    </form>

    <!-- Form Tambah Penggunaan Bahan Baku -->
    <form action="{{ route('bahan.baku.store.penggunaan') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_penggunaan">Penggunaan Bahan Baku</label>
            <input type="text" name="nama_penggunaan" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="khusus">Digunakan untuk Acara Khusus</label>
            <input type="checkbox" name="khusus" value="1">
        </div>
        <button type="submit" class="btn btn-primary">Tambah Penggunaan</button>
    </form>
</div>
@endsection
