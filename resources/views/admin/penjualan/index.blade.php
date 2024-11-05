@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penjualan</h1>
    </div>

 <!-- Content Row -->
<div class="row">
    <div class="col-md-12">
        <div id="statistik-container" class="d-flex flex-wrap">
            
        </div>
        <div class="card">
            <div class="card-body">
                <table id="penjualanTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Tanggal</th>
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
    const FormatRupiah = num => {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      }).format(num);
    }
    var table = $('#penjualanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route(Auth::user()->role == 'admin' ? 'data.penjualan' : 'kasir.data.penjualan') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {
                    data: 'menu.nama',
                },
                {  data: "jumlah" },
                {  data: "harga",
                    render: function(data) {
                        return FormatRupiah(data);
                    }
  
                },
                {  data: "status",
                    render : function(item){
                        let badge;
                        if(item === 'pending'){
                            badge = 'info';
                        }else if(item === 'proses'){
                            badge ='warning';
                        }else if(item === 'selesai'){
                            badge ='success';
                        }else if(item === 'batal'){
                            badge ='secondary';
                        }else{
                            badge ='danger';
                        }
                        return `<span class="badge badge-${badge} text-capitalize">${item}</span>`;
                    }
                 },
                {   data: "created_at",
                    render : function(item){
                        const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
                        const date = new Date(item);
                        return date.toLocaleDateString('id-ID', options);
                    }
                 },
            ],
            order: [[1, 'desc']]
        });

        function headerStatistik() {
            $.ajax({
                url: "{{route('data.penjualan')}}",
                type: 'GET',
                data:{
                    tab: true,
                },
                success: function(response) {
                    const data = response;
                    console.log('data', data)
                   

                    // Mengubah objek menjadi array
                    const result = Object.values(response);

                    // Menambahkan elemen-elemen hasil ke dalam HTML
                    const container = document.getElementById('statistik-container');
                    container.innerHTML = ''; // Mengosongkan container terlebih dahulu

                    result.forEach(data => {
                        let warna;
                        if(data.status == 'selesai'){
                            warna = 'success';
                        }else if(data.status == 'batal'){
                            warna = 'secondary';
                        }else if(data.status == 'pending'){
                            warna = 'info';
                        }else if(data.status == 'proses'){
                            warna = 'warning';
                        }
                        const html = `
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-${warna} shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-${warna} text-uppercase mb-1">
                                                ${data.status}</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">${FormatRupiah(data.pendapatan)}</div>
                                            </div>
                                            <div class="col-auto">
                                                QTY ${data.qty}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += html;
                    });
                }
            });
        }


        headerStatistik();
});
</script>
@endpush
