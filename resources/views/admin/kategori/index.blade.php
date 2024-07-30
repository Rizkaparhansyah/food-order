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
                    <button id="addKategori" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                </div> 
                <div class="card-body">
                    <table id="kategoriTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="kategoriForm">
                        @csrf
                        <input type="hidden" id="kategoriId">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveKategori">Simpan</button>
                    </form>
                </div>
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

        var table = $('#kategoriTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('data.kategori') }}',
            columns: [
                { data: 'nama', name: 'nama' },
                { data: 'deskripsi', name: 'deskripsi' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#addKategori').click(function () {
            $('#kategoriModal').modal('show');
            $('#modalTitle').text('Tambah Kategori');
            $('#kategoriForm')[0].reset();
            $('#kategoriId').val('');
        });

        $('#kategoriTable').on('click', '.editKategori', function () {
            var id = $(this).data('id');
            $.get("{{ url('admin/kategori') }}/" + id + "/edit", function (data) {
                $('#kategoriModal').modal('show');
                $('#modalTitle').text('Edit Kategori');
                $('#kategoriId').val(data.id);
                $('#nama').val(data.nama);
                $('#deskripsi').val(data.deskripsi);
            });
        });

        $('#kategoriTable').on('click', '.deleteKategori', function () {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/kategori') }}/" + id,
                    success: function (data) {
                        table.ajax.reload();
                        alert('Kategori berhasil dihapus');
                    },
                    error: function (data) {
                        alert('Terjadi kesalahan');
                    }
                });
            }
        });

        $('#kategoriForm').submit(function (e) {
            e.preventDefault();
            var id = $('#kategoriId').val();
            var url = id ? "{{ url('admin/kategori') }}/" + id : "{{ url('admin/kategori') }}";
            $.ajax({
                type: id ? "PUT" : "POST",
                url: url,
                data: $('#kategoriForm').serialize(),
                success: function (data) {
                    $('#kategoriModal').modal('hide');
                    table.ajax.reload();
                    alert('Kategori berhasil disimpan');
                },
                error: function (data) {
                    alert('Terjadi kesalahan');
                }
            });
        });
    });
</script>


@endpush
