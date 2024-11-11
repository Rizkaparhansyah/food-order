@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 ">Kelola Bahan Baku</h1>
        <h3 class="h4 mb-0 ">Daftar Jenis dan Penggunaan Bahan Baku</h3>
    </div>

 <!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?php if (Auth::user()->role == 'admin'){ ?>
            <div class="card-header">
                <!-- Button trigger modal -->
                <button type="button" id="addBahan" class="btn btn-primary" data-toggle="modal"
                data-target="#modalTambah">
                    Tambah Bahan Baku
                </button>
            </div>
            <?php } ?>
            <div class="card-body">
                <table id="bahanTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Bahan Baku</th>
                            <th>Subkategori</th>
                            <th>Penggunaan Bahan Baku</th>
                            <th>Acara Khusus</th>
                            
                            @if(Auth::user()->role == 'admin')
                            
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bahan Baku</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="bahanBakuForm" action="" method="post">
                <div class="modal-body">
                        @csrf
                    
                    <input type="hidden" class="form-control" id="idBB" name="idBB">
                    <div class="form-group">
                        <label for="jns_bhn">Jenis Bahan Baku</label>
                        <input type="text" class="form-control" name="jns_bhn" id="jns_bhn">
                    </div>
                    <div class="form-group">
                        <label for="subkategori">Subkategori</label>
                        <input type="text" class="form-control" name="subkategori" id="subkategori">
                    </div>
                    <div class="form-group">
                        <label for="penggunaan_bhn">Penggunakan Bahan Baku</label>
                        <input type="text" class="form-control" name="penggunaan_bhn" id="penggunaan_bhn">
                    </div>
                    <div class="form-group">
                        <label for="role">Digunakan Acara Khusus</label>
                        <input type="checkbox" name="khusus" id="khusus">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="simpanUser">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

  
    
@endsection

@push('script')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

    $('#addBahan').click(function () {
        $('#bahanBakuForm')[0].reset();
        $('#idBB').val('');
        $('#modalTambah').modal('show');
    });

    $('#bahanBakuForm').on('submit', function  (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = "{{ url('bahan-baku')}}"
        
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (data) {
                    $('#modalTambah').modal('hide');
                    $('#bahanTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', 'Data berhasil disimpan.', 'success');
                },
                error: function (xhr, status, error) {
                    var errorMessage = xhr.responseJSON.errors;
                    var errorHtml = '';
                    for (var key in errorMessage) {
                        errorHtml += '<p>' + errorMessage[key] + '</p>';
                    }
                    Swal.fire('Gagal!', errorHtml, 'error');
                }
            })
        })
   
        $('#bahanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/bahan-baku',
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Menambahkan header AJAX
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'jns_bhn', name: 'jns_bhn' },
                { data:'subkategori', name:'subkategori' },
                { data: 'penggunaan_bhn', name: 'penggunaan_bhn' },
                { data: 'khusus', name: 'khusus', searchable: false,
                    render: function(data, type, row) {
                        return data == 'on' ? 'Ya' : 'Tidak';
                    }
                },
                { data: 'action', name: 'action',}
            ]
        })


    $('#bahanTable').on('click', '.edit', function() {
        var data = $(this).data('info'); // Ambil data-info
        // var data = JSON.parse(dataInfo); // Ubah dari JSON ke objek JavaScript
        console.log('data', data)
        // Isi form dengan data yang diambil
        $('#idBB').val(data.id);
        $('#jns_bhn').val(data.jns_bhn);
        $('#penggunaan_bhn').val(data.penggunaan_bhn);
        $('#subkategori').val(data.subkategori);
        // Jika digunakan acara khusus, munculkan checkbox
        if (data.khusus == 'on') {
            $('#khusus').prop('checked', true);
        } else {
            $('#khusus').prop('checked', false);
        }
        
        $('#modalTambah').modal('show');
        $('#khusus').val(data.khusus);
        
        $('#modalTambah').modal('show');
    });

    
    $('#bahanTable').on('click', '.delete', function() {
        var data = $(this).data('info'); // Ambil data-info
        
        // Konfirmasi sebelum menghapus
        if (confirm('Apakah Anda yakin ingin menghapus barang ' + data.nama_brg + '?')) {
            $.ajax({
                url: '/bahan-baku/' + data.id, // Ganti dengan URL yang sesuai untuk menghapus
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Mengambil token CSRF
                },// Metode HTTP untuk menghapus
                success: function(response) {
                    // Tampilkan pesan sukses atau lakukan aksi lain
                    Swal.fire('Sukses!', 'Data penerimaan barang berhasil disimpan.', 'success');
                    // Muat ulang DataTable untuk memperbarui tampilan
                    $('#bahanTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    // Tampilkan pesan kesalahan
                    alert('Gagal menghapus data: ' + xhr.responseText);
                }
            });
        }
    });

})

</script>
@endpush
