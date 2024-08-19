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
                    <button href="" id="addMenu" class="btn btn-primary" data-toggle="modal" data-target="#addMenuModal"><i class="fa fa-plus"></i> Tambah</button>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Menu Modal -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addMenuForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMenuModalLabel">Tambah Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select class="form-control" id="kategori_id" name="kategori_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control-file" id="foto" name="foto">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="form-group">
                            <label for="diskon">Diskon</label>
                            <input type="number" class="form-control" id="diskon" name="diskon">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Menu Modal -->
    <div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editMenuForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select class="form-control" id="kategori_id" name="kategori_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control-file" id="foto" name="foto">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="form-group">
                            <label for="diskon">Diskon</label>
                            <input type="number" class="form-control" id="diskon" name="diskon">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Delete Menu Modal -->
    <div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMenuModalLabel">Hapus Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus menu ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
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

    $(document).ready(function () {
    function formatRupiah(amount) {
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        });
        return formatter.format(amount);
    }

    var table = $('#menuTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('data.menu') }}',
        columns: [
            { data: 'nama', name: 'nama' },
            { data: 'kategori', name: 'kategori' },
            { data: 'deskripsi', name: 'deskripsi' },
            { data: 'foto', name: 'foto', render: function (data, type, row) {
                    return '<img src="' + data + '" height="50"/>';
                }
            },
            { data: 'harga', name: 'harga', render: function (data, type, row) {
                    return formatRupiah(data);
                }
            },
            { data: 'stok', name: 'stok' },
            { data: 'diskon', name: 'diskon', render: function (data, type, row) {
                    return data ? data + '%' : '-';
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#addMenuForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#addMenuModal').modal('hide');
                table.ajax.reload();
                alert('Menu berhasil ditambahkan');
            },
            error: function (response) {
                alert('Terjadi kesalahan, coba lagi nanti');
            }
        });
    });

    $('#menuTable').on('click', '.edit-menu', function () {
        var id = $(this).data('id');
        $.get('{{ url('admin/menu') }}/' + id + '/edit', function (data) {
            $('#editMenuModal').modal('show');
            $('#editMenuForm').attr('action', '{{ url('admin/menu') }}/' + id);
            $('#editMenuForm').find('input[name="nama"]').val(data.menu.nama);
            $('#editMenuForm').find('select[name="kategori_id"]').val(data.menu.kategori_id);
            $('#editMenuForm').find('textarea[name="deskripsi"]').val(data.menu.deskripsi);
            $('#editMenuForm').find('input[name="stok"]').val(data.menu.stok);
            $('#editMenuForm').find('input[name="harga"]').val(data.menu.harga);
            $('#editMenuForm').find('input[name="diskon"]').val(data.menu.diskon);
            
            // Update category options
            var kategoriSelect = $('#editMenuForm').find('select[name="kategori_id"]');
            kategoriSelect.empty();
            $.each(data.categories, function(index, category) {
                kategoriSelect.append('<option value="'+category.id+'">'+category.nama+'</option>');
            });
            kategoriSelect.val(data.menu.kategori_id);
        });
    });


    $('#editMenuForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#editMenuModal').modal('hide');
                table.ajax.reload();
                alert('Menu berhasil diupdate');
            },
            error: function (response) {
                alert('Terjadi kesalahan, coba lagi nanti');
            }
        });
    });

    $('#menuTable').on('click', '.delete-menu', function () {
        var id = $(this).data('id');
        $('#deleteMenuModal').modal('show');
        $('#confirmDelete').data('id', id);
    });

    $('#confirmDelete').click(function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'DELETE',
            url: '{{ url('admin/menu') }}/' + id,
            success: function (response) {
                $('#deleteMenuModal').modal('hide');
                table.ajax.reload();
                alert('Menu berhasil dihapus');
            },
            error: function (response) {
                alert('Terjadi kesalahan, coba lagi nanti');
            }
        });
    });
});

</script>
@endpush