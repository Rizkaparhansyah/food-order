@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order</h1>
    </div>

 <!-- Content Row -->
<div class="row">
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header">
                <!-- Button trigger modal -->
                <input id="cariMenu" class="form-control" placeholder="Cari menu"/>
                
            </div>
            <div class="card-body">
                <div class="row gap-2" id="dataMenu">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="h2 text-center card-header">
                Keranjang
            </div>
            <div class="card-body">
                <div class="row" id="dataKeranjang">
                   
                </div>
                <div class="row" id="identitas">
                    <input type="text" class="mb-2 form-control col-sm-12 col-lg-6" id="namaPemesan" placeholder="Nama">
                    <input type="number" class="mb-2 form-control  col-sm-12 col-lg-6" id="kodePemesan" placeholder="Nomor">
                </div>
                <div class="row" id="orderManual">
                   <div class="btn btn-primary w-100">ORDER</div>
                </div>
            </div>
        </div>
    </div>
</div>

  
@endsection

@push('script')
<script>
$(document).ready(function() {
    const alertSwal = (icon, title, message) => {
        Swal.fire({
            icon: icon,
            title: title,
            text: message,
            showConfirmButton: false,
            timer: 1500
        });
    };
    let datas = [];
    function formatCurrencyIDR(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0, // Tidak menampilkan angka di belakang koma
            maximumFractionDigits: 0  // Tidak menampilkan angka di belakang koma
        }).format(amount);
    }
 
    const loadData = () => {
        $.ajax({
            url: '{{route('data.menu')}}',
            type: 'GET',
            success: (response) => {
                $('#dataMenu').empty(); // Kosongkan elemen dataMenu
                response.map((data) => {
                    let jsonData = JSON.stringify(data).replace(/"/g, '&quot;');
                    let html ='';
                    if (data.stok < 1) {
                        html = `
                        <div class="card col-lg-4 col-md-6 col-sm-12">
                                <div style="width:100%; height:200px;" class="position-relative">
                                    
                                    <div class="h-100 position-absolute bottom-0 top-0 d-flex justify-content-center align-items-center" style="width: 100%; background-color: rgba(0, 0, 0, 0.7); color: white; padding: 10px; "><h1>STOK HABIS</h1></div>
                                    <img class="w-100 object-fit-contain h-100" src="{{asset('storage/')}}/${data.foto}" alt="${data.nama}">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">${data.nama}</h5>
                                    <h5 class="card-title">Rp 0</h5>
                                    <p class="card-text">-</p>
                                    <button disabled class="btn btn-primary w-100">Pesan</button>
                                </div>
                            </div>
                        `;
                    }
                    else {
                         html = `
                            <div class="card col-lg-4 col-md-6 col-sm-12 menu-item" data-data="${jsonData}" data-nama="${data.nama.toLowerCase()}" data-kategori="${data.kategori.nama.toLowerCase()}">
                               <div style="width:100%; height:200px;" class="position-relative">
                                    
                                    <img class="w-100 object-fit-contain h-100" src="{{asset('storage/')}}/${data.foto}" alt="${data.nama}">
                                </div>
                                <div class="card-body w-100">
                                    <h5 class="card-title">${data.nama}</h5>
                                    <h5 class="card-title">${formatCurrencyIDR(data.harga * (1 - data.diskon / 100))}</h5>
                                    <p class="card-text">${data.deskripsi}</p>
                                    <button class="btn btn-primary w-100 pesan" data-id="${data.id}" data-item="${jsonData}">Pesan</button>
                                </div>
                            </div>
                        `;
                        
                    }
                    $('#dataMenu').append(html);
                });
                // $('#dataMenu').html(response);
            }
        })
    }

    $("#cariMenu").keyup(function() {
        var filter = $(this).val().toLowerCase();

        $(".menu-item").each(function() {
            var nama = $(this).data('nama');
            var kategori = $(this).data('kategori');

            // Tampilkan atau sembunyikan item berdasarkan pencarian
            if (nama.includes(filter) ||kategori.includes(filter)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('#cariMenu').on('keypress', function(e) {
        if (e.which === 13) { // Cek apakah tombol yang ditekan adalah "Enter"
            e.preventDefault(); // Mencegah aksi default dari tombol Enter
            
            var filter = $(this).val().toLowerCase();
            var firstMatch = null; // Variabel untuk menyimpan elemen yang cocok pertama kali

            $(".menu-item").each(function() {
                var nama = $(this).data('nama');
                var kategori = $(this).data('kategori');

                // Tampilkan atau sembunyikan item berdasarkan pencarian
                if (nama.includes(filter) || kategori.includes(filter)) {
                    if (firstMatch === null) {
                        firstMatch = $(this); // Simpan elemen yang cocok pertama kali
                    }
                }
            });

            // Ambil data dari elemen yang cocok pertama kali
            if (firstMatch) {
                var dataString = firstMatch.attr('data-data'); // Ambil string JSON dari atribut data
                var dataObject = JSON.parse(dataString); // Konversi kembali ke objek
                // datas.push(dataObject);
                console.log('Data item pertama yang cocok:', dataObject); 
                
                addItemToKeranjang(dataObject);
                $(this).val(''); 
                // Cetak objek tanpa tanda kurung tambahan
            } else {
                console.log('Tidak ada item yang cocok.');
            }
        }
    });

    const loadKeranjang = () => {
        $('#dataKeranjang').empty(); // Kosongkan elemen dataKeranjang

        if (datas.length > 0) {
            $('#orderManual').attr('hidden', false); //
            $('#identitas').attr('hidden', false); //
            datas.map((item, i) => {
                let qty = cartItems[item.id]; // Ambil qty dari cartItems
    
                let html = `
                    <div class="card mb-3 border-bottom-0" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img class="rounded-0 card-img h-100 " src="{{asset('storage/${item.foto}')}}" alt="${item.nama}">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title">${item.nama}</h5>
                                    <p class="card-text">${formatCurrencyIDR(item.harga * (1 - item.diskon / 100))}</p>
                                    <div class="card-text d-flex justify-content-around align-items-center">
                                        <i data-id="${item.id}" class="fa-solid fa-minus p-1 border border-1 rounded-circle minqty color-utama"></i>
                                        <input type="hidden" class="qty${i}" value="${qty}"/>
                                        <div class="color-utama">${qty}</div>
                                        <i data-id="${item.id}" class="fa-solid fa-plus p-1 border border-1 rounded-circle plusqty color-utama"></i>
                                    </div>
                                </div>
                            </div>
                            <div id='delete-datas' data-id="${item.id}" class="col-md-1 d-flex justify-content-center align-items-center">
                                <i class="fas fa-fw fa-trash text-danger"></i>
                            </div>
                        </div>
                        <input type="text" class="catatan${i} border rounded-0 rounded-bottom form-control" placeholder="Catatan pesanan"/>
                    </div>
                    <hr class="mt-2 mb-2"/>
                `; 
                $('#dataKeranjang').append(html);
            });
        }else{
            $('#orderManual').attr('hidden', true); //
            $('#identitas').attr('hidden', true); //
        }
    }

    let cartItems = {}; // Menyimpan { id: qty }

    const addItemToKeranjang = (item) => {
        // Jika item dengan id yang sama sudah ada, tambahkan qty
        if (cartItems[item.id]) {
            cartItems[item.id] += 1; // Tambah qty
        } else {
            cartItems[item.id] = 1; // Set default qty ke 1
            datas.push(item); // Tambahkan item baru ke datas jika belum ada
        }

        loadKeranjang();
    };

    $(document).on('click', '.pesan', function(e) {
        e.preventDefault();
        const item = $(this).data('item'); // Mengambil data dari atribut data-item
        addItemToKeranjang(item);
    });

    $(document).on('click', '.plusqty', function() {
        let id = $(this).data('id');
        cartItems[id] += 1; // Tambah qty
        loadKeranjang(); // Perbarui tampilan
    });

    $(document).on('click', '.minqty', function() {
        let id = $(this).data('id');
        if (cartItems[id] > 1) {
            cartItems[id] -= 1; // Kurangi qty
        } 
        loadKeranjang(); // Perbarui tampilan
    });

    $(document).on('click', '#orderManual', function() {
        const namaPemesan = $('#namaPemesan').val();
        const kodePemesan = $('#kodePemesan').val();
        if(namaPemesan == '' && kodePemesan == '') {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Mohon isi nama dan kode pelanggan.',
                icon: 'warning',
                confirmButtonText: 'Oke'
            });
            return false;
        }else{
            datas.forEach((item, index) => {
                const catatan = $(`.catatan${index}`).val();
                const qty = $(`.qty${index}`).val();
                datas[index].nama_pelanggan = namaPemesan;
                datas[index].via_order = 'manual';
                datas[index].catatan = catatan;
                datas[index].kode_pelanggan = kodePemesan;
                datas[index].qty = qty;
            });
    
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: "btn btn-success",
                  cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
            title: "Apakah pesananmu sudah benar?",
            text: `Tolong siapkan uang anda untuk melakukan payment:)`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Benar!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('checkout')}}',
                        type: 'POST',
                        data:  {
                            data: 
                            JSON.stringify(datas)
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                        swalWithBootstrapButtons.fire({
                            title: "Berhasil!",
                            text: "Silahkan cek proses pesanan anda!",
                            icon: "success"
                        });
                                                
                        datas.splice(0, datas.length);
                        loadKeranjang()
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                });} 
                });
        }
            
        // console.log('datas', datas)
    });

    $(document).on('click', '#delete-datas', function(event){
        event.preventDefault();
        let id = $(this).data('id');
        datas = datas.filter(item => item.id!== id);
        loadKeranjang();
    })

    loadKeranjang();
    loadData();
});
</script>
@endpush
