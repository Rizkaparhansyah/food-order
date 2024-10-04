@extends('admin.layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pesanan Pembelian</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" id="addPesananBtn">Tambah Pesanan Pembelian</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="pesananTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Pesanan</th>
                                <th>Nama Supplier</th>
                                <th>Tanggal Pesanan</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="pesananModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Pesanan Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="pesananForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="pesananId">
                        <div class="form-group">
                            <label for="nomor_pesanan">Nomor Pesanan</label>
                            <input type="text" class="form-control" name="nomor_pesanan" id="nomor_pesanan" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_supplier">Nama Supplier</label>
                            <input type="text" class="form-control" name="nama_supplier" id="nama_supplier" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pesanan">Tanggal Pesanan</label>
                            <input type="date" class="form-control" name="tanggal_pesanan" id="tanggal_pesanan" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="total_harga">Total Harga</label>
                            <input type="number" class="form-control" name="total_harga" id="total_harga" required>
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" name="catatan" id="catatan" required></textarea>
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
        function formatRupiah(amount) {
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            });
            return formatter.format(amount);
        }

        var table = $('#pesananTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.pesanan_pembelian.data') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nomor_pesanan', name: 'nomor_pesanan' },
                { data: 'nama_supplier', name: 'nama_supplier' },
                { data: 'tanggal_pesanan', name: 'tanggal_pesanan' },
                { data: 'status', name: 'status' },
                {
                    data: 'total_harga',
                    name: 'total_harga',
                    render: function (data) {
                        return formatRupiah(data);
                    }
                },
                { data: 'catatan', name: 'catatan' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Show modal untuk menambahkan pesanan baru
        $('#addPesananBtn').click(function () {
            $('#pesananForm')[0].reset();
            $('#pesananId').val('');
            $('#modalLabel').text('Tambah Pesanan Barang');
            $('#pesananModal').modal('show');
        });

        // Save or Update Pesanan Barang
        $('#pesananForm').submit(function (e) {
            e.preventDefault();
            var id = $('#pesananId').val();
            var url = id ? '{{ url('admin/pesanan_pembelian') }}/' + id : '{{ route('admin.pesanan_pembelian.store') }}';
            var method = id ? 'PUT' : 'POST';

            $.ajax({
                type: method,
                url: url,
                data: $(this).serialize(),
                success: function (response) {
                    $('#pesananModal').modal('hide');
                    table.ajax.reload();
                    alert('Data Pesanan Barang berhasil disimpan!');
                },
                error: function (xhr) {
                    alert('Terjadi kesalahan, coba lagi nanti.');
                }
            });
        });

        // Edit Pesanan Barang
        $('#pesananTable').on('click', '.editPesanan', function () {
            var id = $(this).data('id');
            $.get('{{ url('admin/pesanan_pembelian') }}/' + id + '/edit', function (data) {
                $('#modalLabel').text('Edit Pesanan Barang');
                $('#pesananId').val(data.id);
                $('#nomor_pesanan').val(data.nomor_pesanan);
                $('#nama_supplier').val(data.nama_supplier);
                $('#tanggal_pesanan').val(data.tanggal_pesanan);
                $('#status').val(data.status);
                $('#total_harga').val(data.total_harga);
                $('#catatan').val(data.catatan);
                $('#pesananModal').modal('show');
            });
        });

        // Delete Pesanan Barang
        $('#pesananTable').on('click', '.deletePesanan', function () {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ url('admin/pesanan_pembelian') }}/' + id,
                    success: function (response) {
                        table.ajax.reload();
                        alert('Data Pesanan Barang berhasil dihapus!');
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
