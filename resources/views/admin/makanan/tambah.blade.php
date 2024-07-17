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
                    <a href="{{ route('menuMakanan') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div> 
                <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-4">
                                <x-adm.input type="text" label="Nama" name="nama" value="" attr="required" />
                            </div>
                            <div class="col-md-4">
                                <x-adm.input type="text" label="Harga" name="harga" value="" attr="required" />
                            </div>
                            <div class="col-md-4">
                                <x-adm.input type="text" label="Diskon" name="diskon" value="" attr="required" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <x-adm.textarea tlabel="Deskripsi" tname="deskripsi" tvalue="" tattr="required style=height:100px" /> 
                            </div>
                            <div class="col-md-6 mt-2">
                                <x-adm.input type="file" label="Gambar" name="gambar" value="" attr="required onchange=tampilGambar()" />
                                <img src="" alt="preview-gambar" class="preview-gambar mt-2" style="display: none; width: 100px">
                            </div>
                            <div class="col-md-12 mt-2">
                                <x-adm.submit />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function tampilGambar() {
            var gambar = document.querySelector('#gambar');
            var tampil = document.querySelector('.preview-gambar');
            var fileGambar = new FileReader();

            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                tampil.src = e.target.result;
            }

            tampil.style.display = 'block';
        }
    </script>
@endpush