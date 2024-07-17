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
                    <a href="{{ route('makananTambah') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                </div> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table hovered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><img src="https://allofresh.id/blog/wp-content/uploads/2023/05/coklat-batangan-yang-enak-1.jpg" alt="" width="100"></td>
                                            <td>Coklat</td>
                                            <td>Rp. 15.000</td>
                                            <td>50</td>
                                            <td>
                                                <button class="btn btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                
                                                <button class="btn btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection