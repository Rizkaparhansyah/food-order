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
                <!-- Button trigger modal -->
                <button type="button" id="addKategori" class="btn btn-primary" data-toggle="modal"
                data-target="#modalTambah">
                    Tambah Kategori
                </button>
                
            </div>
            <div class="card-body">
                <table id="kategoriTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Kategori</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="idVal">
                    <label for="kategori">Nama kategori</label>
                    <input type="text" class="form-control" id="kategori" placeholder="Ex: Makanan">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" rows="3" placeholder="Deskripsikan kategori anda"></textarea>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="simpanKategori">Simpan</button>
            </div>
        </div>
    </div>
</div>

  
@endsection

@push('script')
<script>
$(document).ready(function() {

    $('#kategoriTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('data.kategori') }}',
        columns: [
            { data: 'id', name: 'id', visible: false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama', name: 'nama' },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'aksi', name: 'aksi' }
        ],
        order: [[0, 'desc']]
    });
    const deleteData = id => {
        $.ajax({
            url: '/admin/kategori-hapus/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alertSwal('success', 'Berhasil!', 'Data berhasil dihapus.');
                $('#kategoriTable').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                alertSwal('error', 'Gagal!', 'Data gagal dihapus.');
            }
        });
    }

    window.konfirmasiHapus = id => {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteData(id);
            }
        });
    }

    const alertSwal = (icon, title, message) => {
        Swal.fire({
            icon: icon,
            title: title,
            text: message,
            showConfirmButton: false,
            timer: 1500
        });
    };
    
    $(document).on('hidden.bs.modal', function(event){
        $('#idVal').val('');
        $('#kategori').val('');
        $('#deskripsi').val('');
    })
    $(document).on('click', '#edit', function(){
        $('#idVal').val('');
        event.preventDefault();
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const deskripsi = $(this).data('deskripsi');
        $('#idVal').val(id);
        $('#kategori').val(nama);
        $('#deskripsi').val(deskripsi);
    })

    $('#simpanKategori').click(function(event) {
        
        event.preventDefault();
        $.ajax({
            url: '{{ route('tambah.kategori') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nama: $('#kategori').val(),
                deskripsi: $('#deskripsi').val(),
                id: $('#idVal').val(),
            },
            success: function(response) {
                $('#kategori').val('')
                $('#deskripsi').val('')
                if (response.success) { 
                    alertSwal('success', 'Berhasil', 'Kategori berhasil ditambahkan');
                }else{
                    alertSwal('error', 'Gagal', 'Kategori gagal ditambahkan');
                    
                }
                $('#modalTambah').modal('hide');
                $('#kategoriTable').DataTable().ajax.reload();
            },
            error: function(response) {
                console.log('response', response)
                alertSwal('warning', 'Gagal', 'Mungkin kategori sudah terdaftar?');
            }

        });
    });

  
});
</script>
@endpush
