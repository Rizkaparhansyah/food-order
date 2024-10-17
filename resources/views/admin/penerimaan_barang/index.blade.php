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
                                <th>Nama Barang / Bahan Baku</th>
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
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="penerimaanModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                        <!-- Dropdown untuk memilih Pesanan Pembelian -->
                        <div class="form-group">
                            <label for="pesanan_pembelian_id">Pilih Pesanan Pembelian</label>
                            <select name="pesanan_pembelian_id" id="pesanan_pembelian_id" class="form-control" required>
                                <option value="">-- Pilih Pesanan Pembelian --</option>
                                @foreach($pesananPembelian as $pesanan)
                                    <option value="{{ $pesanan->id }}" 
                                            data-nama-barang="{{ $pesanan->nama_barang }}" 
                                            data-nama-pemasok="{{ $pesanan->nama_pemasok }}">
                                        {{ $pesanan->nama_pemasok }} - {{ $pesanan->nama_barang }} - {{ $pesanan->tanggal_pesanan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" required>
                        </div> --}}
                        <!-- Input untuk Nama Barang -->
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" readonly>
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
                        {{-- <div class="form-group">
                            <label for="nama_pemasok">Nama Pemasok</label>
                            <input type="text" class="form-control" name="nama_pemasok" id="nama_pemasok" required>
                        </div> --}}
                        <!-- Input untuk Nama Pemasok -->
                        <div class="form-group">
                            <label for="nama_pemasok">Nama Pemasok</label>
                            <input type="text" name="nama_pemasok" id="nama_pemasok" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nomor_faktur">Nomor Faktur</label>
                            <input type="text" class="form-control" name="nomor_faktur" id="nomor_faktur" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi Penyimpanan</label>
                        <select class="form-control" id="lokasi" name="lokasi" required>
                            <option value="" disabled selected>Pilih Lokasi Penyimpanan</option>
                            <option value="Gudang">Gudang</option>
                            <option value="Dapur">Dapur</option>
                        </select>
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

        var table = $('#penerimaanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.penerimaan_barang.data') }}',
            columns: [
                { data: 'id', name: 'id' },
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

        // Show modal untuk menambahkan daftar Penerimaan Barang baru
        $('#addPenerimaanBtn').click(function () {
            $('#penerimaanForm')[0].reset();
            $('#penerimaanId').val('');
            $('#modalLabel').text('Tambah Penerimaan Barang');
            $('#penerimaanModal').modal('show');
        });

        // Dynamic Total Price Calculation
        $('#jumlah, #harga_satuan').on('input', function() {
            var jumlah = parseFloat($('#jumlah').val()) || 0;
            var hargaSatuan = parseFloat($('#harga_satuan').val()) || 0;
            $('#total_harga').val(jumlah * hargaSatuan);
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

        // // Edit Penerimaan Barang
        // $('#penerimaanTable').on('click', '.editPenerimaan', function () {
        //     var id = $(this).data('id');
        //     $.get('{{ url('admin/penerimaan_barang') }}/' + id + '/edit', function (data) {
        //         $('#modalLabel').text('Edit Penerimaan Barang');
        //         $('#penerimaanId').val(data.id);
        //         $('#nama_barang').val(data.nama_barang);
        //         $('#jumlah').val(data.jumlah);
        //         $('#harga_satuan').val(data.harga_satuan);
        //         $('#total_harga').val(data.total_harga);
        //         $('#tanggal_penerimaan').val(data.tanggal_penerimaan);
        //         $('#nama_pemasok').val(data.nama_pemasok);
        //         $('#nomor_faktur').val(data.nomor_faktur);
        //         $('#lokasi').val(data.lokasi);
        //         $('#penerimaanModal').modal('show');
        //     });
        // });

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
                $('#lokasi').val(data.lokasi);

                // Nonaktifkan dropdown pesanan pembelian pada saat edit
                $('#pesanan_pembelian_id').val(data.pesanan_pembelian_id).prop('disabled', true);
                $('#pesanan_pembelian_id').closest('.form-group').hide(); // Sembunyikan dropdown
                
                $('#penerimaanModal').modal('show');
            });
        });

        // Reset saat add penerimaan baru (mengembalikan dropdown pesanan pembelian)
        $('#addPenerimaanBtn').click(function () {
            $('#penerimaanForm')[0].reset();
            $('#penerimaanId').val('');
            $('#pesanan_pembelian_id').prop('disabled', false).closest('.form-group').show(); // Tampilkan dropdown
            $('#modalLabel').text('Tambah Penerimaan Barang');
            $('#penerimaanModal').modal('show');
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

        // Ketika memilih pesanan pembelian
        $('#pesanan_pembelian_id').change(function() {
            var selectedOption = $(this).find('option:selected');
            
            // Ambil data nama barang dan nama pemasok dari option yang dipilih
            var namaBarang = selectedOption.data('nama-barang');
            var namaPemasok = selectedOption.data('nama-pemasok');
            
            // Isi kolom nama barang dan nama pemasok dengan data yang diambil
            $('#nama_barang').val(namaBarang);
            $('#nama_pemasok').val(namaPemasok);
        });

        // Update total harga ketika jumlah atau harga satuan diubah
        $('#jumlah, #harga_satuan').on('input', function() {
            var jumlah = parseFloat($('#jumlah').val()) || 0;
            var hargaSatuan = parseFloat($('#harga_satuan').val()) || 0;
            var totalHarga = jumlah * hargaSatuan;
            $('#total_harga').val(totalHarga);
        });
    });
</script>
@endpush
