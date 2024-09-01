@extends('welcome')

@section('title', 'Status Pesanan')
@section('content')

    <section class="container">
        <div class="d-flex pare justify-content-around align-items-center mb-3">
            <div class="line"></div>
            <div class="color-utama bg-white step rounded-circle border border-warning" style="width:80px; height: 80px">
                Pending
            </div>
            <div class="color-utama step bg-white rounded-circle border border-info" style="width:80px; height: 80px">Diproses</div>
            <div class="color-utama step bg-white rounded-circle border border-success" style="width:80px; height: 80px">Selesai</div>
        </div>
        <div class="d-flex pare justify-content-between gap-3">
            <div class="gap-3 w-100 " id="pending">
            </div>

            <div class="gap-3 w-100 " id="proses">
            </div>

            <div class="gap-3 w-100 " id="selesai">

            </div>
        </div>
    </section>
@endsection

@push('css')
    <style>
        .pare {
            position: relative;
        }

        .line {
            top: 50%;
            z-index: -1;
            width: 70%;
            height: 1px;
            background-color: var(--warna-utama);
            position: absolute;
        }

        .step {
            display: flex;
            align-items: center;
            justify-content: center;
            background: 'red';
        }
    </style>
@endpush

@push('script')
    <script>

      $.ajax({
        url: '{{ route("status.user")}}',
        method: 'GET',
        success: function(response) {
            response.forEach(data => {
                let html = data.menu.map(datas => `
                    <div class="card w-100 mb-3">
                        <div class="card-body">
                            <h5 class="card-title">${datas.nama}  x${data.jumlah}</h5>
                            <p class="card-text">${datas.deskripsi}</p>
                        </div>
                    </div>
                `).join(''); // Gabungkan semua elemen HTML menjadi satu string

                // Mapping status ke elemen HTML
                const statusMapping = {
                    'pending': '#pending',
                    'proses': '#proses',
                    'selesai': '#selesai'
                };

                // Tampilkan hasil ke elemen yang sesuai
                $(statusMapping[data.status]).append(html);
            });

        }
      })

    </script>
@endpush
