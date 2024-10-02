@extends('welcome')

@section('title', 'Menu')
@section('content')

    <x-filter-component />

    <div class="container mt-3">
        <div class="row">
            @foreach ($data as $item)
                <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
                    <div class="card p-2">
                        <div class="p-0">
                            <img src="{{ $item->foto }}" style="height: 300px; object-fit:cover"
                                class="col-sm-12 card-img-top rounded" alt="...">
                        </div>
                        <div class="card-body p-0 mt-2">
                            <div class="d-flex justify-content-between">
                                <h2 class="card-title fw-bold">{{ $item->nama }}</h2>
                                <h3 class="card-title fw-medium">{{ $item->kategori->nama }}</h3>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <p class="card-text text-success"><strong>Rp.
                                        {{ number_format($item->harga * (1 - $item->diskon / 100), 0, ',', '.') }}</strong>
                                </p>
                                <p class="card-text text-danger"><small><del>Rp.
                                            {{ number_format($item->harga, 0, ',', '.') }}</del></small></p>
                            </div>
                            <div class="d-flex gap-2">
                                <?php if($item->stok>0) {
                                    ?>
                                <button class="btn bg-kedua color-utama fs-5 col-10" data-url="{{ route('add.cart') }}"
                                    id="pesan" data-id="{{ $item->id }}">Pesan</button>
                                    <?php } else { ?>
                                        <button class="btn bg-secondary bg-opacity-25 color-utama fs-5 col-10 text-dark" data-url="{{ route('add.cart') }}"
                                            id="pesan" data-id="{{ $item->id }}" disabled>Not Available</button>
                                        <?php } ?>

                                <button class="btn color-utama w-100 d-flex justify-content-center align-items-center"
                                    style="border-color: var(--warna-kedua)"
                                    data-bs-toggle="modal"  
                                    data-bs-target="#productModal"
                                    data-name="{{ $item->nama }}"   
                                    data-image="{{ $item->foto }}"   
                                    data-description="{{ $item->deskripsi }}" 
                                    data-id="{{ $item->id }}"> {{-- Menyimpan ID produk untuk digunakan dalam AJAX request --}}
                                    <i class="fa-solid fa-magnifying-glass color-keempat"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="productImage" style="height: 400px; object-fit:cover"
                        src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Product Image" class="rounded img-fluid  mb-3 w-100">
                    <h5 class="modal-title mb-3" id="productModalLabel">Redvelvet</h5>
                    <p id="productDescription" class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Maxime, rem iste libero exercitationem natus eos minus fugit ipsum ullam iusto facilis suscipit
                        dolore explicabo doloremque ipsa error numquam beatae deserunt dicta in recusandae qui.</p>
                    <button class="btn bg-kedua color-utama w-100" id="addToCart">
                        <i class="fa-solid fa-cart-shopping color-utama me-2"></i> Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="productImage" style="height: 400px; object-fit:cover"
                        src=""
                        alt="Product Image" class="rounded img-fluid mb-3 w-100">
                    <h5 class="modal-title mb-3" id="productModalLabel">Product Name</h5>
                    <p id="productDescription" class="mb-3">Product Description</p>
                    <button class="btn bg-kedua color-utama w-100" id="addToCart">
                        <i class="fa-solid fa-cart-shopping color-utama me-2"></i> Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {

            var selectedProductId;

            // Untuk menangani klik ikon pencarian dan memperbarui modal
            $('.btn[data-bs-toggle="modal"]').on('click', function() {
                var productName = $(this).data('name');
                var productImage = $(this).data('image');
                var productDescription = $(this).data('description');
                selectedProductId = $(this).data('id'); // Menyimpan ID produk yang dipilih

                $('#productModalLabel').text(productName);
                $('#productImage').attr('src', productImage);
                $('#productDescription').text(productDescription);
            });

            // Menambahkan item ke keranjang ketika tombol "Keranjang" di modal diklik
            $('#addToCart').on('click', function() {
                var url = '{{ route("add.cart") }}';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_menu: selectedProductId, // Menggunakan ID produk yang disimpan
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Item berhasil ditambahkan ke keranjang');
                        } else {
                            alert('Gagal menambahkan item ke keranjang');
                        }
                    },
                    error: function(response) {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });

            // Kode yang ada untuk menambahkan item ke keranjang dari daftar produk
            $('.btn#pesan').on('click', function() {
                var id_menu = $(this).data('id');
                var url = $(this).data('url');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_menu: id_menu,
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Item berhasil ditambahkan ke keranjang');
                        } else {
                            alert('Gagal menambahkan item ke keranjang');
                        }
                    },
                    error: function(response) {
                        message = response['responseJSON']['error'];
                        if(message == "session invalid"){
                            alert("sesi tidak valid, harap lengkapi nama dan meja terlebih dahulu!");
                            $('#authModal').modal('show');
                        }
                    }
                });
            });
        });
    </script>
@endpush