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

    <a class="btn btn-success mb-3" href="{{ route('meja.index') }}">Status Meja</a>

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
                                <th>Nomor Meja</th>
                                <th class="align-middle text-center">Action</th>
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
                columns: [
                    {
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
                        data: 'nomor_meja',
                        name: 'nomor_meja'
                    },
                    {
                        data: null,
                        name: 'action',
                        className: 'centered-button',
                        orderable: false,
                        searchable: false,
                        defaultContent: '<button class="btn btn-success btn-sm rounded-circle text-center align-middle">...</button>' // Button with "..."
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
                let ordersTable = '<table class="table table-bordered">';
                ordersTable +=
                    '<thead><tr><th>Nama</th><th>Quantity</th><th>Catatan</th><th>Status</th><th>Harga</th><th>Action</th></tr></thead>';
                ordersTable += '<tbody>';
                let totals = 0;
                d.orders.forEach(function(order) {
                    let statusClass;
                    switch (order.status) {
                        case 'proses':
                            statusClass = 'badge-secondary';
                            break;
                        case 'selesai':
                            statusClass = 'badge-success';
                            break;
                        case 'pending':
                            statusClass = 'badge-warning';
                            break;
                        case 'cancel':
                            statusClass = 'badge-danger';
                            break;
                        default:
                            statusClass = 'badge-secondary';
                    }
                    totals += (order.harga_menu * (1-order.diskon / 100)) * order.jumlah;
                    ordersTable += `<tr>
                        <td>${order.nama_menu}</td>
                        <td>${order.jumlah}</td>
                        <td>${(order.catatan == null)?'<i>Tidak Ada Catatan</i>':order.catatan}</td>
                        <td><span class="badge badge-pill ${statusClass}">${order.status}</span></td>
                        <td>Rp. ${ (order.harga_menu * (1-order.diskon / 100)) * order.jumlah }</td>
                        <td class="centered-button">
                            <select class="form-control update-status" data-id="${order.id}">
                                <option value="pending" ${order.status == 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="proses" ${order.status == 'proses' ? 'selected' : ''}>Proses</option>
                                <option value="selesai" ${order.status == 'selesai' ? 'selected' : ''}>Selesai</option>
                                <option value="delete">Delete</option>
                            </select>
                        </td>
                    </tr>`;
                });
                ordersTable += `<tr><td colspan="4" class="font-weight-bold text-right">Total Harga : </td><td colspan="2" class="font-weight-bold">Rp. ${totals}</td></tr>`;
                ordersTable += '</tbody></table>';
                return ordersTable;
            }

            // Handle status update via AJAX
            $(document).on('change', '.update-status', function() {
                const orderId = $(this).data('id');
                const status = $(this).val();

                console.log('Order ID:', orderId); // Check if correct ID is selected
                console.log('Selected status:', status); // Check if "cancel" is being sent

                $.ajax({
                    url: `/admin/pesanan/${orderId}/update-status`,
                    method: 'POST',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.success);
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
@endpush