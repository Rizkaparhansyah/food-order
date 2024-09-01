@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Management User</h1>
    </div>

 <!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <!-- Button trigger modal -->
                <button type="button" id="addUser" class="btn btn-primary" data-toggle="modal"
                data-target="#modalTambah">
                    Tambah User
                </button>
                
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th></th>
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
                <h5 class="modal-title" id="exampleModalLabel">User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="userForm" action="" method="post">
                <div class="modal-body">
                        @csrf
                    
                    <input type="hidden" class="form-control" id="idKondisi">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" id="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanUser">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

  
@endsection

@push('script')
<script>
$(document).ready(function() {
    const alertSwal = (icon, title, message) => {
        Swal.fire({
            icon: icon,
            title: title,
            text: message,
            showConfirmButton: false,
            timer: 1500
        });
    };

    $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('data.user') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'aksi', name: 'aksi' }
        ],
    });

    $('#simpanUser').click(function(event) {
        
        event.preventDefault();
        $.ajax({
            url: '{{ route('tambah.user') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: $('#idKondisi').val(),
                nama: $('#nama').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                role: $('#role').val(),
            },
            success: function(response) {
                $('#nama').val('')
                $('#email').val('')
                $('#password').val('')
                $('#role').val('')
                if (response.success) { 
                    alertSwal('success', 'Berhasil', 'User berhasil ditambahkan');
                }else{
                    alertSwal('error', 'Gagal', 'User gagal ditambahkan');
                }
                $('#modalTambah').modal('hide');
                $('#userTable').DataTable().ajax.reload();
            },
            error: function(response) {
                
            }

        });
    });

    $(document).on('hidden.bs.modal', function(event){
            $('#idMenu').val('');
            $('#nama').val('');
            $('#kategori').val('');
            $('#deskripsi').val('');
            $('#harga').val('');
            $('#stok').val('');
            $('#diskon').val('');
    })

    $('#userForm').on('submit', function(e) {
        e.preventDefault();

        // Ambil seluruh data form
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route('tambah.user') }}',
            type: 'POST',
            _token: '{{ csrf_token() }}',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alertSwal('success', 'Berhasil', response.message);
                $('#userForm').trigger('reset');
                $('#modalTambah').modal('hide');
                $('#userTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alertSwal('error', 'Gagal', 'Data gagal ditambahkan');
            }
        });
    });
    
    $('#addUser').on('click', function(){
        $('#idKondisi').val('');
        $('#nama').val('')
        $('#email').val('')
        $('#password').val('')
        $('#role').val('')
        $('#modalTambah').modal('show');
    })

    $(document).on('click','.editMenu', function(){
        const data = $(this).data('data');
        $('#idKondisi').val(data.id);
        $('#nama').val(data.name);
        $('#email').val(data.email);
        $('#password').val(data.password);
        $('#role').val(data.role);

        $('#modalTambah').modal('show');
    })

    const deleteData = id => {
        $.ajax({
            url: '/admin/user-hapus/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alertSwal('success', 'Berhasil!', 'Data berhasil dihapus.');
                $('#userTable').DataTable().ajax.reload();
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


});
</script>
@endpush
