@extends('admin.layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pesanan Pembelian</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" id="tambahPesananBtn">Tambah Pesanan Pembelian</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="pesananTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pemasok</th>
                                <th>Tanggal Pesanan</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Status Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Tambah/Edit Pesanan -->
    <div class="modal fade" id="pesananModal" tabindex="-1" role="dialog" aria-labelledby="pesananModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="pesananForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pesananModalLabel">Tambah Pesanan Pembelian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="pesananId"> <!-- Hidden field for ID -->
                        <div class="form-group">
                            <label for="nama_pemasok">Nama Pemasok</label>
                            <input type="text" class="form-control" id="nama_pemasok" name="nama_pemasok" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pesanan">Tanggal Pesanan</label>
                            <input type="date" class="form-control" id="tanggal_pesanan" name="tanggal_pesanan" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_satuan">Harga Satuan</label>
                            <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" required>
                        </div>
                        <div class="form-group">
                            <label for="total_harga">Total Harga</label>
                            <input type="number" class="form-control" id="total_harga" name="total_harga" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status Pesanan</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                { data: 'nama_pemasok', name: 'nama_pemasok' },
                { data: 'tanggal_pesanan', name: 'tanggal_pesanan' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'harga_satuan', name: 'harga_satuan', render: function (data, type, row) {
                        return formatRupiah(data);
                    }
                },
                { data: 'total_harga', name: 'total_harga', render: function (data, type, row) {
                        return formatRupiah(data);
                    }
                },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Show modal to add a new Pesanan
        $('#tambahPesananBtn').click(function () {
            $('#pesananForm')[0].reset(); // Clear the form
            $('#pesananModalLabel').text('Tambah Pesanan Pembelian'); // Set modal title
            $('#pesananId').val(''); // Reset hidden ID field
            $('#pesananModal').modal('show'); // Show modal
        });

        // Dynamic Total Price Calculation
        $('#jumlah, #harga_satuan').on('input', function() {
            var jumlah = parseFloat($('#jumlah').val()) || 0;
            var hargaSatuan = parseFloat($('#harga_satuan').val()) || 0;
            $('#total_harga').val(jumlah * hargaSatuan);
        });

        // Save or update Pesanan
        $('#pesananForm').submit(function (e) {
            e.preventDefault();
            var id = $('#pesananId').val();
            var url = id ? '{{ url('admin/pesanan_pembelian') }}/' + id : '{{ route('admin.pesanan_pembelian.store') }}';
            var type = id ? 'PUT' : 'POST';

            $.ajax({
                type: type,
                url: url,
                data: $(this).serialize(),
                success: function (response) {
                    $('#pesananModal').modal('hide');
                    table.ajax.reload();
                    alert('Pesanan Pembelian berhasil disimpan!');
                },
                error: function (xhr) {
                    alert('Terjadi kesalahan, coba lagi nanti.');
                }
            });
        });

        // Edit Pesanan
        $('#pesananTable').on('click', '.editPesanan', function () {
            var id = $(this).data('id');
            $.get('{{ url('admin/pesanan_pembelian') }}/' + id + '/edit', function (data) {
                $('#pesananModalLabel').text('Edit Pesanan Pembelian');
                $('#nama_pemasok').val(data.nama_pemasok);
                $('#tanggal_pesanan').val(data.tanggal_pesanan);
                $('#nama_barang').val(data.nama_barang);
                $('#jumlah').val(data.jumlah);
                $('#harga_satuan').val(data.harga_satuan);
                $('#total_harga').val(data.total_harga);
                $('#status').val(data.status);
                $('#pesananId').val(data.id); // Set ID for editing
                $('#pesananModal').modal('show');
            });
        });

        // Delete Pesanan
        $('#pesananTable').on('click', '.deletePesanan', function () {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ url('admin/pesanan_pembelian') }}/' + id,
                    success: function (response) {
                        table.ajax.reload();
                        alert('Pesanan Pembelian berhasil dihapus!');
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
