@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pesanan</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('order.index')}}" class="btn btn-primary">Tambah Pesanan</a>
                </div>
                <div class="card-body">

                    <table id="example" class="display table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama Pelanggan</th>
                                <th>Kode</th>
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



@endsection

@push('css')
<style>
    .child-row {
        margin-left: 20px;
        background-color: #f9f9f9;
    }

    .child-row table {
        width: 100%;
        border-collapse: collapse;
    }

    .child-row th, .child-row td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .details-control {
        cursor: pointer;
    }
</style>
@endpush

@push('script')
    
<script>
    
 $(document).ready(function() {
        function formatCurrencyIDR(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0, // Tidak menampilkan angka di belakang koma
                maximumFractionDigits: 0  // Tidak menampilkan angka di belakang koma
            }).format(amount);
        }
        
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route( Auth::user()->role == 'admin' ? 'pesanan.list' : 'kasir.pesanan.list') }}",
            columns: [
                {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '<i class="fa-solid fa-chevron-right"></i>'
                },
                { className: 'details-control', data: "nama_pelanggan",
                    render: function (data) { return `<b>${data}</b>`}
                },
                { className: 'details-control', data: "kode_pelanggan", searchable: true },
                { className: 'text-center', data: "aksi" },
            ],
            order: [[1, 'desc']],
            createdRow: function(row, data, dataIndex) {
                var menuItems = data.menuItems || [];
                var backgroundColor = '#ffffff'; // Default white

                if (menuItems.length > 0) {
                    var firstStatus = menuItems[0].status;
                    var allSameStatus = menuItems.every(item => item.status === firstStatus);

                    if (allSameStatus) {
                        if (firstStatus === 'selesai') {
                            backgroundColor = '#d4edda'; // Green for completed
                        } else if (firstStatus === 'pending') {
                            backgroundColor = '#d1ecf1'; // Blue for pending (info)
                        } else if (firstStatus === 'proses') {
                            backgroundColor = '#fff3cd'; // Yellow for in process
                        } else if (firstStatus === 'batal') {
                            backgroundColor = '#d6d8d9'; // Gray for cancelled
                        }
                    }
                }

                $(row).css('background-color', backgroundColor);
            },
            
        });



        $('#example tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                tr.find('td.details-control').first().html('<i class="fa-solid fa-chevron-right"></i>');
            } else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
                tr.find('td.details-control').first().html('<i class="fa-solid fa-chevron-down"></i>');
            }
        });
            

        function format(d) {
            console.log('d', d);
            var menuItems = d.menuItems || []; // Data anak dari row

            var badge = 'info';
            var totalHarga = 0;
            var rows = menuItems.map(item => {
                if(item.status === 'pending'){
                    badge = 'info';
                } else if(item.status === 'proses'){
                    badge = 'warning';
                } else if(item.status === 'selesai'){
                    badge = 'success';
                } else if(item.status === 'batal'){
                    badge = 'secondary';
                } else {
                    badge = 'danger';
                }

                var hargaSetelahDiskon = item.harga * (1 - item.diskon / 100);
                totalHarga += hargaSetelahDiskon;

                return `<tr>
                            <td><b>${item.nama}</b></td>
                            <td>${item.qty}</td>
                            <td>${item.catatan == '' || item.catatan == null ? 'Kosong' : item.catatan}</td>
                            <td>
                                <span class="badge badge-${badge} text-capitalize">${item.status}</span>
                            </td>
                            <td>${formatCurrencyIDR(hargaSetelahDiskon)}</td>
                            <td class="text-center">
                                <div class="btn-group dropleft">
                                    <button type="button" class="btn btn-success rounded-circle justify-content-center align-items-center d-flex" style="width:40px; height:40px;"  data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu dropdown-menu-eleh show" style="width: 240px; background: rgb(255, 255, 255); border: 1px; position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-10px, 0px);" data-popper-placement="left-start">
                                            <div class="d-flex justify-content-around">
                                                <div>
                                                    <button style="width:40px; height:40px;"  onclick="aksiPesananPerData(${d.kode_pelanggan}, '${item.status.toString()}', 'pending', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-info btn-md  justify-content-center align-items-center d-flex"  data-bs-toggle="tooltip" data-bs-placement="top" title="Pending pesanan"><i class="fa fa-hourglass-half"></i></button>
                                                </div>
                                                <div>
                                                    <button style="width:40px; height:40px;"   onclick="aksiPesananPerData(${d.kode_pelanggan}, '${item.status.toString()}','proses', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-warning btn-md  justify-content-center align-items-center d-flex"  data-bs-toggle="tooltip" data-bs-placement="top" title="Proses pesanan"><i class="fa fa-circle-notch"></i></button>
                                                </div>
                                                <div>
                                                    <button style="width:40px; height:40px;"  onclick="aksiPesananPerData(${d.kode_pelanggan}, '${item.status.toString()}','selesai', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-success btn-md  justify-content-center align-items-center d-flex" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: 3%" href="javascript:void(0)" data-bs-placement="top" title="Selesaikan pesanan"><i class="fa fa-check"></i></button>
                                                </div>
                                                <div>
                                                    <button style="width:40px; height:40px;"  onclick="aksiPesananPerData(${d.kode_pelanggan}, '${item.status.toString()}','batal', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-md btn-secondary  justify-content-center align-items-center d-flex" data-bs-toggle="tooltip" data-bs-placement="top" title="Batal pesanan" style="margin-left: 3%"> <i class="fa fa-times"></i></button>
                                                </div>
                                                <div>
                                                    <button onclick="aksiPesananPerData(${d.kode_pelanggan}, '${item.status.toString()}','hapus', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-md btn-danger justify-content-center align-items-center d-flex" style="width:40px; height:40px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus pesanan" style="margin-left: 3%"> <i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
            }).join('');

            // Tambahkan footer dengan total harga
            var footer = `
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total Harga:</th>
                        <th  colspan="2">${formatCurrencyIDR(totalHarga)}</th>
                    </tr>
                </tfoot>`;

            return `
                <div class="child-row">
                    <table cellpadding="5" cellspacing="0" border="1" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Quantity</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rows}
                        </tbody>
                        ${footer} <!-- Tambahkan footer di sini -->
                    </table>
                </div>`;
        }

        window.aksiPesanan = (kode, status) => {
            $.ajax({
                url: "{{ route('pesanan.aksi') }}",
                type: 'POST',
                data: {
                    kode: kode,
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if(response.status){
                        table.ajax.reload();
                    } else{
                        alert(response.message);
                    }
                }
            });
        }

        window.aksiPesananPerData = (kode, statusAwal, status, id, idPesanan) => {
            
            $.ajax({
                url: "{{ route('pesanan.aksi-perdata') }}",
                type: 'POST',
                data: {
                    kode: kode,
                    statusAwal: statusAwal,
                    status: status,
                    id: id,
                    idPesanan: idPesanan,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if(response.status){
                        table.ajax.reload();
                    } else{
                        alert(response.message);
                    }
                }
            });
        }


    });

</script>
@endpush