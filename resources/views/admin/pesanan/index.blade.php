@extends('admin.layouts.app')
<style>
    .centered-button {
        text-align: center;
    }
</style>
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pesanan</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="pesananTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama Pelanggan</th>
                                <th>Kode</th>
                                <th class="align-middle text-center"></th>
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
        $(document).ready(function() {
            function formatCurrencyIDR(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0, // Tidak menampilkan angka di belakang koma
                maximumFractionDigits: 0  // Tidak menampilkan angka di belakang koma
            }).format(amount);
        }
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#pesananTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('data.pesanan') }}',
                columns: [{
                        className: 'details-control',
                        orderable: false,
                        searchable: false,
                        data: null,
                        defaultContent: '<i class="fa fa-chevron-down"></i>'
                    },
                    {
                        data: 'nama_pelanggan',
                        name: 'nama'
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            // Add event listener for opening and closing details
            $('#pesananTable tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).find('i').removeClass('fa-chevron-up').addClass(
                        'fa-chevron-down'); // Change icon to down
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                    $(this).find('i').removeClass('fa-chevron-down').addClass(
                        'fa-chevron-up'); // Change icon to up
                }
            });

            // Formatting function for row details
            function format(d) {
            console.log('d', d)
            // d is the data object for the row
            // Replace this with the data from your menu table
            var orders = d.orders || []; // Assume orders is an array of child data

            var badge = 'info'
            var rows = orders.map(item => {
                if(item.status === 'pending'){
                    badge = 'info';
                }else if(item.status === 'proses'){
                    badge ='warning';
                }else if(item.status === 'selesai'){
                    badge ='success';
                }else if(item.status === 'batal'){
                    badge ='secondary';
                }else{
                    badge ='danger';
                }
                return `<tr>
                            <td>${item.nama}</td>
                            <td>${formatCurrencyIDR(item.harga * (1 - item.diskon / 100))}</td>
                            <td>${item.qty}</td>
                            <td>${item.catatan == '' || item.catatan == null ? 'Kosong' : item.catatan}</td> 
                            <td>
                                <span class="badge badge-${badge} text-capitalize">${item.status}</span>
                            </td>
                            <td class="text-center">
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn btn-success rounded-circle justify-content-center align-items-center d-flex" style="width:40px; height:40px;"  data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <div class="dropdown-menu dropdown-menu-eleh show" style="width: 240px; background: rgb(255, 255, 255); border: 1px; position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-10px, 0px);" data-popper-placement="left-start">
                                                <div class="d-flex justify-content-around">
                                                    <div>
                                                        <button style="width:40px; height:40px;"  onclick="aksiPesananPerData(${d.kode}, '${item.status.toString()}', 'pending', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-info btn-md  justify-content-center align-items-center d-flex"  data-bs-toggle="tooltip" data-bs-placement="top" title="Pending pesanan"><i class="fa fa-hourglass-half"></i></button>
                                                    </div>
                                                    <div>
                                                        <button style="width:40px; height:40px;"   onclick="aksiPesananPerData(${d.kode}, '${item.status.toString()}','proses', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-warning btn-md  justify-content-center align-items-center d-flex"  data-bs-toggle="tooltip" data-bs-placement="top" title="Proses pesanan"><i class="fa fa-circle-notch"></i></button>
                                                    </div>
                                                    <div>
                                                        <button style="width:40px; height:40px;"  onclick="aksiPesananPerData(${d.kode}, '${item.status.toString()}','selesai', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-success btn-md  justify-content-center align-items-center d-flex" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: 3%" href="javascript:void(0)" data-bs-placement="top" title="Selesaikan pesanan"><i class="fa fa-check"></i></button>
                                                    </div>
                                                    <div>
                                                        <button style="width:40px; height:40px;"  onclick="aksiPesananPerData(${d.kode}, '${item.status.toString()}','batal', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-md btn-secondary  justify-content-center align-items-center d-flex" data-bs-toggle="tooltip" data-bs-placement="top" title="Batal pesanan" style="margin-left: 3%"> <i class="fa fa-times"></i></button>
                                                    </div>
                                                    <div>
                                                        <button onclick="aksiPesananPerData(${d.kode}, '${item.status.toString()}','hapus', ${item.id} , ${d.id_pesanan})" class="btn btn-rounded rounded-circle btn-md btn-danger justify-content-center align-items-center d-flex" style="width:40px; height:40px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus pesanan" style="margin-left: 3%"> <i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </td>
                        </tr>`;
            }).join('');

            return '<div class="child-row">' +
                        '<table cellpadding="5" cellspacing="0" border="1" style="width:100%;">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>Nama</th>' +
                                    '<th>Harga</th>' +
                                    '<th>Quantity</th>' +
                                    '<th>Catatan</th>' +
                                    '<th>Status</th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                                rows +
                            '</tbody>' +
                        '</table>' +
                   '</div>';
        }

        });

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
                        table.ajax.reload();
                   
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
                        table.ajax.reload();
                }
            });
        }
    </script>
@endpush
