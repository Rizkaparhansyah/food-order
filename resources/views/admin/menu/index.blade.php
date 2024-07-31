@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Makanan</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button href="" id="addMenu" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                </div> 
                <div class="card-body">

                    <table id="menuTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Diskon</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    
<script>
    $(document).ready( function () {
        function formatRupiah(amount) {
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            });
            return formatter.format(amount);
        }

        $('#menuTable').DataTable(
            {
                processing: true,
                serverSide: true,
                ajax: '{{ route('data.menu') }}',
                columns: [
                    { data: 'nama', name: 'nama' },
                    { data: 'kategori', name: 'kategori' },
                    { data: 'deskripsi', name: 'deskripsi' },
                    { data: 'foto', name: 'foto', orderable: false, searchable: false, render: function(data) {
                        return '<img src="' + data + '" width="50" height="50">';
                    }},
                    { data: 'harga', name: 'harga', render: function(data) {
                        return formatRupiah(data);
                    }},
                    { data: 'stok', name: 'stok' },
                    { data: 'diskon', name: 'diskon', render: function(data) {
                        return `<p>${data}%</p>`;
                    }}
                ]
            });
    } );
</script>
@endpush