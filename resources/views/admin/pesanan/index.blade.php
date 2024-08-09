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
                // Create a table inside the child row
                let ordersTable = '<table class="table table-bordered">';
                ordersTable +=
                    '<thead><tr><th>Nama</th><th>Harga</th><th>Quantity</th><th>Status</th><th></th></tr></thead>';
                ordersTable += '<tbody>';

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
                        default:
                            statusClass = 'badge-secondary'; // Default class
                    }

                    ordersTable += `<tr>
                                <td>${order.nama_menu}</td>
                                <td>${order.harga_menu}</td>
                                <td>${order.jumlah}</td>
                                <td><span class="badge badge-pill ${statusClass}">${order.status}</span></td>
                                <td class="centered-button"><button class="btn btn-success btn-sm rounded-circle text-center align-middle">....</button></td>
                            </tr>`;
                });

                ordersTable += '</tbody></table>';
                return ordersTable;
            }

        });
    </script>
@endpush
