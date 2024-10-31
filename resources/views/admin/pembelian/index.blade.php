@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pembelian Barang</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card"> 
                <div class="card-header">
                <!-- Button trigger modal -->
                    <button type="button" id="pesananModalButton" class="btn btn-primary" data-toggle="modal"
                    data-target="#pesananModal">
                        Tambah Barang
                    </button>
                
                </div>
                <div class="card-body">

                    <table id="pembelianBarangTable" class="w-100 display table table-bordered" style="width:100%">
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pesananModal" tabindex="-1" role="dialog" aria-labelledby="pesananModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="pesananForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pesananModalLabel">Pesanan Pembelian</h5>
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
                            <input type="text" disabled class="disabled form-control" id="total_harga" name="total_harga" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status Pesanan</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
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

@push('css')
@endpush

@push('script')
    
<script>
    
    $(document).ready(function() {
        const FormatRupiah = num => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(num);
        }
        const alertSwal = (icon, title, message) => {
            Swal.fire({
                icon: icon,
                title: title,
                text: message,
                showConfirmButton: false,
                timer: 1500
            });
        };
        function refreshData() {
            $('#pembelianBarangTable').DataTable().destroy();
            loadData();
        }
        $('#harga_satuan').on('input', function() {
            var hargaSatuan = $(this).val();
            var jumlah = $('#jumlah').val();
            var totalHarga = hargaSatuan * jumlah;
            $('#total_harga').val(totalHarga);
        })
        $('#pesananForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah form dari submit biasa

            var formData = {
                pesananId: $('#pesananId').val(),
                nama_pemasok: $('#nama_pemasok').val(),
                tanggal_pesanan: $('#tanggal_pesanan').val(),
                nama_barang: $('#nama_barang').val(),
                jumlah: $('#jumlah').val(),
                harga_satuan: $('#harga_satuan').val(),
                total_harga: $('#total_harga').val(),
                status: $('#status').val()
            };

            $.ajax({
                url: '/pembelian-barang', // URL untuk route resource
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Mengambil token CSRF
                },
                success: function(response) {
                    // Tindakan setelah data berhasil disimpan
                    refreshData();
                    $('#pesananModal').modal('hide'); // Menutup modal setelah sukses
                    alertSwal('success', 'Berhasil!', 'Data berhasil disimpan.');
                },
                error: function(xhr) {
                    // Tindakan jika terjadi kesalahan
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan saat menyimpan data');
                }
            });
        });


        function loadData() {
            // Memuat data table
            var table = $('#pembelianBarangTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/pembelian-barang',
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Menambahkan header AJAX
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama_pemasok', name: 'nama_pemasok' },
                    { data: 'tgl_pesanan', name: 'tgl_pesanan' },
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
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']]
            });

           
        }

        $('#pembelianBarangTable').on('click', '.edit', function() {
            var data = $(this).data('info'); // Ambil data-info
            // var data = JSON.parse(dataInfo); // Ubah dari JSON ke objek JavaScript

            // Isi form dengan data yang diambil
            $('#pesananId').val(data.id);
            $('#nama_pemasok').val(data.nama_pemasok);
            $('#tanggal_pesanan').val(data.tgl_pesanan);
            $('#nama_barang').val(data.nama_brg);
            $('#jumlah').val(data.jumlah);
            $('#harga_satuan').val(data.harga_satuan);
            $('#total_harga').val(data.total_harga);
            $('#status').val(data.status);
            
            $('#pesananModal').modal('show');
        });

        $('#pembelianBarangTable').on('click', '.hapus', function() {
            var data = $(this).data('info'); // Ambil data-info
            
            // Konfirmasi sebelum menghapus
            if (confirm('Apakah Anda yakin ingin menghapus pemasok ' + data.nama_pemasok + '?')) {
                $.ajax({
                    url: '/pembelian-barang/' + data.id, // Ganti dengan URL yang sesuai untuk menghapus
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Mengambil token CSRF
                    },// Metode HTTP untuk menghapus
                    success: function(response) {
                        // Tampilkan pesan sukses atau lakukan aksi lain
                        alertSwal('success', 'Berhasil!', 'Data berhasil dihapus.');
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

        $('#pembelianBarangTable').on('click', '.print', function() {
            var data = $(this).data('info'); // Ambil data-info
            // Buat konten untuk dicetak
            var printContent = `
                <div style="text-align:center; margin-top:100px">
                    <h1 style="font-weight:bold; margin-bottom: 50px">Pesanan Pembelian</h1>
                    <h1 style="font-weight:bold; margin-bottom: 50px"></h1>
                    <table style="margin: 0 auto; border-collapse: collapse; width: 80%;">
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nama Pemasok</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.nama_pemasok}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Tanggal Pesanan</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.tgl_pesanan}</td>
                        </tr>
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
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Total Harga</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.total_harga}</td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Status</th>
                            <td style="border: 1px solid #ddd; padding: 8px;">${data.status}</td>
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

        $('#pesananModal').on('hidden.bs.modal', function () {
            
            $('#pesananId').val(''); // Mengosongkan semua input form
            $('#pesananForm')[0].reset(); // Mengosongkan semua input form
        });


        loadData()
    });

</script>
@endpush