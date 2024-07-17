@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Form Tambah</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <a href="#" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a> --}}

                    <a href="#" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <x-adm.input type="text" label="Nama" name="nama" value="" attr="" />

                            <x-adm.input type="file" label="Nama" name="nama"  value="" attr="" />

                            <x-adm.textarea tlabel="Alamat" tname="alamat" tvalue="" tattr="" />

                            <x-adm.submit />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection