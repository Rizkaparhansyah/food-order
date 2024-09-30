@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Bahan Baku</h1>

    <!-- Tampilkan pesan error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bahanbaku.update', $bahanBaku->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="jenis">Jenis Bahan Baku</label>
            <input type="text" name="jenis" class="form-control" value="{{ $bahanBaku->jenis }}" required>
        </div>
        <div class="form-group">
            <label for="subkategori">Subkategori</label>
            <input type="text" name="subkategori" class="form-control" value="{{ $bahanBaku->subkategori }}">
        </div>
        <div class="form-group">
            <label for="penggunaan">Penggunaan Bahan Baku</label>
            <input type="text" name="penggunaan" class="form-control" value="{{ $bahanBaku->penggunaan }}" required>
        </div>
        <div class="form-group">
            <label for="khusus">Digunakan untuk Acara Khusus</label>
            <input type="checkbox" name="khusus" value="1" {{ $bahanBaku->khusus ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">Update Bahan Baku</button>
    </form>
</div>
@endsection