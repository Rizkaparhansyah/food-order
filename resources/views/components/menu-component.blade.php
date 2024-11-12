@extends('welcome')

@section('title', 'Menu')
@section('content')

    <x-filter-component/>

    <div class="container mt-3">
        <div class="row" id="menu-container">
            <!-- Data menu akan diisi di sini dengan AJAX -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="productModalLabel1" class="text-center w-100 color-keempat"></h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="productImage" style="height: 400px; object-fit:cover" src="" alt="Product Image"
                        class="rounded img-fluid  mb-3 w-100">
                    <h5 class="modal-title mb-3 color-keempat" id="productModalLabel"></h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"><strong id="productHargaDiskon"></strong></p>
                        <p class="card-text text-danger" id="disc"><small><del id="productHarga"></del></small></p>
                    </div>
                    <p id="productDescription" class="color-keempat mb-3"></p>
                    <button class="btn bg-kedua color-keempat w-100 addToCart" id="addToCart">
                        <i class="fa-solid fa-cart-shopping color-keempat me-2"></i> Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        function formatCurrencyIDR(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0, // Tidak menampilkan angka di belakang koma
                maximumFractionDigits: 0 // Tidak menampilkan angka di belakang koma
            }).format(amount);
        }

        function calculateDiscountedPrice(originalPrice, discountPercentage) {
            return originalPrice - (originalPrice * (discountPercentage / 100));
        }

        function pesan(id) {
            event.preventDefault();
            cekAuthUser('menu', 'add', id)
        };

        function detail(id, foto, nama, deskripsi, harga, diskon) {
            console.log('data', id)
            $('#addToCart').attr('data-id', id);
            $('#productImage').attr('src', '{{ asset('storage') }}/' + foto);
            $('#productModalLabel1').text(nama);
            $('#productModalLabel').text(nama);
            $('#productDescription').text(deskripsi);
            $('#productHargaDiskon').text(formatCurrencyIDR(calculateDiscountedPrice(harga, diskon)));
            $('#productHarga').text(formatCurrencyIDR(harga));
            if (formatCurrencyIDR(harga) == formatCurrencyIDR(calculateDiscountedPrice(harga, diskon))) {
                $('#disc').attr('hidden', 'true');
            } else {
                $('#disc').removeAttr('hidden');
            }
            $('#productModal').modal('show');
        }

        $(document).ready(function() {
            function loadMenuData(kategori = '', search = '') {
                $('#searchInput').val(search);
                $.ajax({
                    url: "{{ route('menu.filter') }}",
                    method: 'GET',
                    data: {
                        kategori: kategori,
                        search: search
                    },
                    success: function(response) {
                        let menuContainer = $('#menu-container');
                        menuContainer.empty(); // Kosongkan container
                        console.log(response.data);

                        // Loop untuk setiap item menu
                        if (response.data.length > 0) {
                            response.data.forEach(item => {
                                let stokHabis = item.stok < 1;
                                let card = ``;
                                if (item.stok < 1) {
                                    card = `
                                        <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
                                            <div class="position-relative card p-2" style="border-color: var(--warna-keempat)">
                                                <div class="p-0 position-relative">
                                                    <div class="position-absolute bottom-0 top-0 end-0 d-flex justify-content-center align-items-center" style="width: 100%; background-color: rgba(0, 0, 0, 0.7); color: white; padding: 10px; "><h1>STOK HABIS</h1></div>
                                                    <img src="{{ asset('storage') }}/${item.foto}" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                                                </div>
                                                <div class="card-body p-0 mt-2">
                                                    <div class="d-flex justify-content-between">
                                                        <h2 class="card-title fw-bold color-keempat">${item.nama}</h2>
                                                        <h3 class="card-title fw-medium color-keempat">${item.kategori.nama}</h3>
                                                    </div>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button disabled class="btn bg-keempat color-keempat fs-5 col-10">Pesan</button>
                                                        <button disabled class=" btn color-keempat w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-keempat)"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                } else {
                                    let hargaDiskon = item.diskon > 0 ?
                                        `<p class="card-text text-danger"><small><del>Rp. ${new Intl.NumberFormat('id-ID').format(item.harga)}</del></small></p>` :
                                        '';
                                    let diskon = item.diskon > 0 ?
                                        `<span class="position-absolute badge bg-danger rounded-0 end-0 top-0 text-bg-warning fs-4 d-flex justify-content-center align-items-center" style="width: 50px; height:50px">${item.diskon}%</span>` :
                                        '';
                                    card = `
                                    <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
                                        <div class="position-relative card p-2" style="border-color: var(--warna-keempat)">
                                            ${diskon}
                                            <div class="p-0">
                                                <img src="{{ asset('storage') }}/${item.foto}" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                                            </div>
                                            <div class="card-body p-0 mt-2">
                                                <div class="d-flex justify-content-between">
                                                    <h2 class="card-title fw-bold color-keempat">${item.nama}</h2>
                                                    <h3 class="card-title fw-medium color-ketiga">${item.kategori.nama}</h3>
                                                </div>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    <p class="card-text text-success"><strong>Rp. ${new Intl.NumberFormat('id-ID').format(item.harga * (1 - item.diskon / 100))}</strong></p>
                                                    ${hargaDiskon}
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn bg-kedua color-keempat fs-5 col-10 pesan" data-url="{{ route('cart') }}" onclick="pesan(${item.id})" id="pesan" data-id="${item.id}">Pesan</button>
                                                    <button id="detail" class="detail btn color-keempat w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" onclick="detail(${item.id},'${item.foto}','${item.nama}','${item.deskripsi}',${item.harga},${item.diskon})" data-data="${item}"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                }
                                menuContainer.append(card);
                            });
                        } else {
                            menuContainer.html(
                                '<h1 class="color-keempat text-center">Data Produk Belum Tersedia</h1>'
                            );
                        }
                    },
                    error: function(error) {
                        console.error("Terjadi kesalahan:", error);
                    }
                });
            };

            // Event klik untuk tombol kategori
            $('.kategori-filter').on('click', function() {
                event.stopPropagation();
                $('.kategori-filter').removeClass('bg-kedua');
                $(this).addClass('bg-kedua');
                let kategori = $(this).data('kategori');
                loadMenuData(kategori, $('#searchInput').val());
            });

            // Event submit untuk form pencarian
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                let search = $('#searchInput').val();
                loadMenuData($('.kategori-filter.bg-kedua').data('kategori') || '', search);
            });

            // Load data menu awal
            loadMenuData('semua','');

            const pesanButton = $('.pesan');
            const addToCart = $('.addToCart');

            addToCart.on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id')
                cekAuthUser('menu', 'add', id)
                $('#productModal').modal('hide');
            });
        })
    </script>
@endpush
