@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Kategori</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button href="" id="addKategori" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                </div> 
                <div class="card-body">

                    <table id="kategoriTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
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

        $('#kategoriTable').DataTable(
            {
                processing: true,
                serverSide: true,
                ajax: '{{ route('data.kategori') }}',
                columns: [
                    { data: 'nama', name: 'nama' },
                    { data: 'deskripsi', name: 'deskripsi' },
                ]
            });
    } );
</script>
@endpush