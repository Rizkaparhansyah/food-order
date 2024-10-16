@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row" id="statistik-container">
        
    </div>
    <div class="row d-flex">
        <div class="card col-6">
            <div class="card-body">
                <canvas id="chartPendapatan"></canvas>
            </div>
        </div>
        <div class="card col-6">
            <div class="card-body">
                <canvas id="chartStatus"></canvas>
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
        // Your JavaScript code here
        function headerStatistik() {
            $.ajax({
                url: "{{route('data.penjualan')}}",
                type: 'GET',
                data:{
                    tab: true,
                },
                success: function(response) {
                    const data = response;
                    
                    var labels = [];
                    var datasetData = [];
                    
                    // Mengubah objek menjadi array
                    const result = Object.values(response);
                    
                    console.log('data', result)
                    // Menambahkan elemen-elemen hasil ke dalam HTML
                    const container = document.getElementById('statistik-container');
                    container.innerHTML = ''; // Mengosongkan container terlebih dahulu
                    
                    const chartPendapatan = document.getElementById('chartPendapatan');
                    const chartStatus = document.getElementById('chartStatus');
                
                   
                    result.forEach(data => {
                    
                        labels.push(data.status); // Asumsikan 'status' adalah field yang Anda inginkan
                        datasetData.push(data.pendapatan);
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
                    const datas = {
                        labels: labels,
                        datasets: [{
                            label: 'Total',
                            data:datasetData,
                            backgroundColor: [
                                'rgb(54, 162, 235)',
                                'rgb(51, 204, 51)',
                                'rgb(255, 205, 86)',
                            ],
                            hoverOffset: 4
                        }]
                    };
                    const config = {
                        type: 'doughnut',
                        data: datas,
                    };
                    new Chart(chartStatus, config);
                    new Chart(chartPendapatan, {
                        type: 'bar',
                        data: {
                        labels: labels,
                        datasets: [{
                            label: 'Grafik',
                            data: datasetData,
                            borderWidth: 1,
                            backgroundColor: [
                                'rgb(54, 162, 235)',
                                'rgb(51, 204, 51)',
                                'rgb(255, 205, 86)',
                            ],
                        }]
                        },
                        options: {
                        scales: {
                            y: {
                            beginAtZero: true
                            }
                        }
                        }
                    });
                }
            });
        }


        headerStatistik();
    
    });

        
   
</script>
@endpush