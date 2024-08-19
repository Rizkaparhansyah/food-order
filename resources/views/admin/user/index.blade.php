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
                    <button id="addUser" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                </div> 
                <div class="card-body">
                    <table id="userTable" class="table table-bordered">
                        <thead>
                            <tr> 
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
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
                <button type="submit" class="btn btn-primary" id="simpanUser">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script> 
    $(document).ready(function () {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

    $('#addUser').on('click', function(){
        $('#idKondisi').val('');
        $('#nama').val('')
        $('#email').val('')
        $('#password').val('')
        $('#role').val('')
        $('#modalTambah').modal('show');
    })

$('#userForm').on('submit', function(e){
    e.preventDefault(); 
console.log('test')
    var formData = new FormData(this);

    $.ajax({
        type: 'POST', 
        url: '{{ route('store.user') }}',
        data: formData,
        processData: false, 
        contentType: false, 
        success: function(data){
            $('#modalTambah').modal('hide')
            $('#userTable').DataTable().ajax.reload()
        }
    })
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

        });
</script>


@endpush
