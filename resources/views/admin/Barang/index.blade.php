@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Barang</h1>
    </div>

    <!-- Add Barang Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Tambah Barang</h5>
        </div>
        <div class="card-body">
            <form id="barangForm">
                @csrf
                <input type="hidden" id="barangId">
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
                    <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="total_harga">Total Harga</label>
                    <input type="number" class="form-control" id="total_harga" name="total_harga" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_penerimaan">Tanggal Penerimaan</label>
                    <input type="date" class="form-control" id="tanggal_penerimaan" name="tanggal_penerimaan" required>
                </div>
                <div class="form-group">
                    <label for="nama_pemasok">Nama Pemasok</label>
                    <input type="text" class="form-control" id="nama_pemasok" name="nama_pemasok" required>
                </div>
                <div class="form-group">
                    <label for="nomor_faktur">Nomor Faktur</label>
                    <input type="text" class="form-control" id="nomor_faktur" name="nomor_faktur" required>
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi Penyimpanan</label>
                    <select class="form-control" id="lokasi" name="lokasi" required>
                        <option value="" disabled selected>Pilih Lokasi Penyimpanan</option>
                        <option value="Gudang">Gudang</option>
                        <option value="Dapur">Dapur</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="saveBarang">Simpan</button>
                <button type="button" class="btn btn-secondary" id="cancelEdit">Batal</button> <!-- Cancel Button -->
            </form>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="barangTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Nama Pemasok</th>
                                <th>Nomor Faktur</th>
                                <th>Lokasi Penyimpanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
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

        // Initialize DataTable
        var table = $('#barangTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('data.Barang') }}',
            columns: [
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
                { data: 'tanggal_penerimaan', name: 'tanggal_penerimaan' },
                { data: 'nama_pemasok', name: 'nama_pemasok' },
                { data: 'nomor_faktur', name: 'nomor_faktur' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Submit Form
        $('#barangForm').submit(function (e) {
            e.preventDefault();
            var id = $('#barangId').val();
            var url = id ? "{{ url('admin/Barang') }}/" + id : "{{ url('admin/Barang') }}";
            var type = id ? "PUT" : "POST";

            $.ajax({
                type: type,
                url: url,
                data: $('#barangForm').serialize(),
                success: function (data) {
                    $('#barangForm')[0].reset();
                    $('#barangId').val('');
                    table.ajax.reload();
                    alert('Barang berhasil disimpan');
                },
                error: function (data) {
                    alert('Terjadi kesalahan');
                }
            });
        });

        // Edit Barang
        $('#barangTable').on('click', '.editBarang', function () {
            var id = $(this).data('id');
            $.get("{{ url('admin/Barang') }}/" + id + "/edit", function (data) {
                $('#barangId').val(data.id);
                $('#nama_barang').val(data.nama_barang);
                $('#jumlah').val(data.jumlah);
                $('#harga_satuan').val(data.harga_satuan);
                $('#total_harga').val(data.total_harga);
                $('#tanggal_penerimaan').val(data.tanggal_penerimaan);
                $('#nama_pemasok').val(data.nama_pemasok);
                $('#nomor_faktur').val(data.nomor_faktur);
                $('#lokasi').val(data.lokasi);
            });
        });

        // Cancel Edit
        $('#cancelEdit').click(function () {
            $('#barangForm')[0].reset();
            $('#barangId').val('');
        });

        // Delete Barang
        $('#barangTable').on('click', '.deleteBarang', function () {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/Barang') }}/" + id,
                    success: function (data) {
                        table.ajax.reload();
                        alert('Barang berhasil dihapus');
                    },
                    error: function (data) {
                        alert('Terjadi kesalahan');
                    }
                });
            }
        });
    });
</script>
@endpush
