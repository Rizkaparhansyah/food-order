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
                        <input type="hidden" name="penerimaanId" id="penerimaanId">
                        <!-- Dropdown untuk memilih Pesanan Pembelian -->
                        <div class="form-group nama">
                            <label for="pesanan_pembelian_id">Pilih Pesanan Pembelian</label>
                            <select name="pesanan_pembelian_id" id="pesanan_pembelian_id" class="form-control" required>
                                <option value="">-- Pilih Pesanan Pembelian --</option>
                                @foreach($pesananPembelian as $pesanan)
                                    <option value="{{ $pesanan->id }}" 
                                            data-nama-barang="{{ $pesanan->nama_brg }}" 
                                            data-nama-pemasok="{{ $pesanan->nama_pemasok }}"
                                            data-all="{{$pesanan}}">
                                        {{ $pesanan->nama_pemasok }} - {{ $pesanan->nama_brg }} - {{ $pesanan->tgl_pesanan }}
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
                            <input type="date" class="form-control" name="tgl_penerimaan" id="tanggal_penerimaan" required>
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
                        <div class="form-group">
                            <label for="lokasi">Lokasi Penyimpanan</label>
                            <select class="form-control" id="lokasi" name="lokasi" required>
                                <option value="" disabled selected>Pilih Lokasi Penyimpanan</option>
                                <option value="Gudang">Gudang</option>
                                <option value="Dapur">Dapur</option>
                            </select>
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
        const FormatRupiah = num => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }).format(num);
        }

        function loadData() {
            // Memuat data table
            var table = $('#penerimaanTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/penerimaan-barang',
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Menambahkan header AJAX
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama_brg', name: 'nama_brg' },
                    { data: 'jumlah', name: 'jumlah' },
                    { data: 'harga_satuan', name: 'harga_satuan',
                        render: function(data){
                            return FormatRupiah(parseFloat(data)); // Format rupiah
                        }
                     },
                    { data: 'total_harga', name: 'total_harga',
                        render: function(data){
                            return FormatRupiah(parseFloat(data)); // Format rupiah
                        } 
                    },
                    { data: 'tgl_penerimaan', name: 'tgl_penerimaan' },
                    { data: 'nama_pemasok', name: 'nama_pemasok' },
                    { data: 'no_faktur', name: 'no_faktur' },
                    { data: 'lok_penyimpanan', name: 'lok_penyimpanan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']]
            });

           
        }

        loadData();

        $('#penerimaanForm').on('submit', function  (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var url = "{{ url('penerimaan-barang')}}"
        
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (data) {
                    $('#penerimaanModal').modal('hide');
                    $('#penerimaanTable').DataTable().ajax.reload();
                    Swal.fire('Sukses!', 'Data penerimaan barang berhasil disimpan.', 'success');
                },
                error: function (xhr, status, error) {
                    var errorMessage = xhr.responseJSON.errors;
                    var errorHtml = '';
                    for (var key in errorMessage) {
                        errorHtml += '<p>' + errorMessage[key] + '</p>';
                    }
                    Swal.fire('Gagal!', errorHtml, 'error');
                }
            })
        })
        // Dynamic Total Price Calculation
        $('#jumlah, #harga_satuan').on('input', function() {
            var jumlah = parseFloat($('#jumlah').val()) || 0;
            var hargaSatuan = parseFloat($('#harga_satuan').val()) || 0;
            $('#total_harga').val(jumlah * hargaSatuan);
        });

 
        // Reset saat add penerimaan baru (mengembalikan dropdown pesanan pembelian)
        $('#addPenerimaanBtn').click(function () {
            $('#penerimaanForm')[0].reset();
            $('#penerimaanId').val('');
            $('.nama').attr('hidden', false);
            $('#modalLabel').text('Tambah Penerimaan Barang');
            $('#penerimaanModal').modal('show');
        });

        function refreshData() {
            $('#penerimaanTable').DataTable().destroy();
            loadData();
        }

        // Ketika memilih pesanan pembelian
        $('#pesanan_pembelian_id').change(function() {
            var selectedOption = $(this).find('option:selected');
            // Ambil data nama barang dan nama pemasok dari option yang dipilih
            var namaBarang = selectedOption.data('nama-barang');
            var namaPemasok = selectedOption.data('nama-pemasok');
            var data = selectedOption.data('all');
            // Isi kolom nama barang dan nama pemasok dengan data yang diambil
            $('#jumlah').val(data.jumlah);
            $('#harga_satuan').val(data.harga_satuan);
            $('#total_harga').val(data.total_harga);
            $('#tanggal_penerimaan').val(data.tanggal_pesanan);
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

        $('#penerimaanTable').on('click', '.hapus', function() {
            var data = $(this).data('info'); // Ambil data-info
            
            // Konfirmasi sebelum menghapus
            if (confirm('Apakah Anda yakin ingin menghapus barang ' + data.nama_brg + '?')) {
                $.ajax({
                    url: '/penerimaan-barang/' + data.id, // Ganti dengan URL yang sesuai untuk menghapus
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Mengambil token CSRF
                    },// Metode HTTP untuk menghapus
                    success: function(response) {
                        // Tampilkan pesan sukses atau lakukan aksi lain
                        Swal.fire('Sukses!', 'Data penerimaan barang berhasil disimpan.', 'success');
                        // Muat ulang DataTable untuk memperbarui tampilan
                        refreshData();
                    },
                    error: function(xhr) {
                        // Tampilkan pesan kesalahan
                        alert('Gagal menghapus data: ' + xhr.responseText);
                    }
                });
            }
        });

        $('#penerimaanTable').on('click', '.edit', function() {
            $('.nama').attr('hidden', true);
            $('#modalLabel').text('Edit Penerimaan Barang');
            var data = $(this).data('info'); // Ambil data-info
            // var data = JSON.parse(dataInfo); // Ubah dari JSON ke objek JavaScript

            // Isi form dengan data yang diambil
            $('#penerimaanId').val(data.id);
            $('#nama_barang').val(data.nama_brg);
            $('#jumlah').val(data.jumlah);
            $('#harga_satuan').val(data.harga_satuan);
            $('#total_harga').val(data.total_harga);
            $('#tanggal_penerimaan').val(data.tgl_penerimaan);
            $('#nama_pemasok').val(data.nama_pemasok);
            $('#nomor_faktur').val(data.no_faktur);
            $('#lokasi').val(data.lok_penyimpanan);
            
            $('#penerimaanModal').modal('show');
        });

        $('#penerimaanTable').on('click', '.print', function() {
            var data = $(this).data('info'); // Ambil data-info
            // Buat konten untuk dicetak
            var printContent = `
                <div style="text-align:center; margin-top:100px">
                    <h1 style="font-weight:bold; margin-bottom: 50px">Penerimaan Barang</h1>
                    <h1 style="font-weight:bold; margin-bottom: 50px"></h1>
                    <table style="margin: 0 auto; border-collapse: collapse; width: 80%;">
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nama Barang</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.nama_brg}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Jumlah</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.jumlah}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Harga Satuan</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.harga_satuan}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Total</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.total_harga}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Tanggal Penerimaan</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.tgl_penerimaan}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nama Pemasok</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.nama_pemasok}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">No Faktur</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.no_faktur}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Lokasi Penyimpanan</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.lok_penyimpanan}</td>
                        </tr>
                    </table>
                </div>
            `;


            // Buka jendela baru untuk mencetak
            var printWindow = window.open('', '', 'height=400,width=600');
            printWindow.document.write('<html><head><title>Cetak Data</title>');
            printWindow.document.write('<style>body{font-family: Arial, sans-serif;}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close(); // Penting untuk menutup dokumen
            printWindow.print(); // Jalankan fungsi print
        });
    });
</script>
@endpush