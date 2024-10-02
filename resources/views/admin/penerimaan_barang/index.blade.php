@extends('admin.layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Penerimaan Barang</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" id="addPenerimaanBtn">Tambah Penerimaan Barang</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="penerimaanTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Nama Pemasok</th>
                                <th>Nomor Faktur</th>
                                <th>Aksi</th>
                                <th>Dokumen</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="penerimaanModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Penerimaan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="penerimaanForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="penerimaanId">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_satuan">Harga Satuan</label>
                            <input type="number" class="form-control" name="harga_satuan" id="harga_satuan" required>
                        </div>
                        <div class="form-group">
                            <label for="total_harga">Total Harga</label>
                            <input type="number" class="form-control" name="total_harga" id="total_harga" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_penerimaan">Tanggal Penerimaan</label>
                            <input type="date" class="form-control" name="tanggal_penerimaan" id="tanggal_penerimaan" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_pemasok">Nama Pemasok</label>
                            <input type="text" class="form-control" name="nama_pemasok" id="nama_pemasok" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_faktur">Nomor Faktur</label>
                            <input type="text" class="form-control" name="nomor_faktur" id="nomor_faktur" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Simpan</button>
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

    $(document).ready(function () {
        var table = $('#penerimaanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.penerimaan_barang.data') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'harga_satuan', name: 'harga_satuan' },
                { data: 'total_harga', name: 'total_harga' },
                { data: 'tanggal_penerimaan', name: 'tanggal_penerimaan' },
                { data: 'nama_pemasok', name: 'nama_pemasok' },
                { data: 'nomor_faktur', name: 'nomor_faktur' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
                {
                    data: null,
                    name: 'Dok',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<a href="/admin/penerimaan_barang/' + row.id + '/pdf" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i> PDF</a>';
                    }
                }
            ]
        });

        // Show modal untuk menambahkan daftar Penerimaan Barang baru
        $('#addPenerimaanBtn').click(function () {
            $('#penerimaanForm')[0].reset();
            $('#penerimaanId').val('');
            $('#modalLabel').text('Tambah Penerimaan Barang');
            $('#penerimaanModal').modal('show');
        });

        // Save or Update Penerimaan Barang
        $('#penerimaanForm').submit(function (e) {
            e.preventDefault();
            var id = $('#penerimaanId').val();
            var url = id ? '{{ url('admin/penerimaan_barang') }}/' + id : '{{ route('admin.penerimaan_barang.store') }}';
            var type = id ? 'PUT' : 'POST';

            $.ajax({
                type: type,
                url: url,
                data: $(this).serialize(),
                success: function (response) {
                    $('#penerimaanModal').modal('hide');
                    table.ajax.reload();
                    alert('Data Penerimaan Barang berhasil disimpan!');
                },
                error: function (xhr) {
                    alert('Terjadi kesalahan, coba lagi nanti.');
                }
            });
        });

        // Edit Penerimaan Barang
        $('#penerimaanTable').on('click', '.editPenerimaan', function () {
            var id = $(this).data('id');
            $.get('{{ url('admin/penerimaan_barang') }}/' + id + '/edit', function (data) {
                $('#modalLabel').text('Edit Penerimaan Barang');
                $('#penerimaanId').val(data.id);
                $('#nama_barang').val(data.nama_barang);
                $('#jumlah').val(data.jumlah);
                $('#harga_satuan').val(data.harga_satuan);
                $('#total_harga').val(data.total_harga);
                $('#tanggal_penerimaan').val(data.tanggal_penerimaan);
                $('#nama_pemasok').val(data.nama_pemasok);
                $('#nomor_faktur').val(data.nomor_faktur);
                $('#penerimaanModal').modal('show');
            });
        });

        // Delete Penerimaan Barang
        $('#penerimaanTable').on('click', '.deletePenerimaan', function () {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ url('admin/penerimaan_barang') }}/' + id,
                    success: function (response) {
                        table.ajax.reload();
                        alert('Data Penerimaan Barang berhasil dihapus!');
                    },
                    error: function (xhr) {
                        alert('Terjadi kesalahan, coba lagi nanti.');
                    }
                });
            }
        });
    });
</script>
@endpush