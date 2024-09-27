@extends('welcome')

@section('title', 'Menu')
@section('content')

<x-filter-component/>

<div class="container mt-3">
    <div class="row">
        @if ($data->count() > 0)    
            @foreach ($data as $item)
            @if ($item->stok < 1)
                <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
                    <div class="position-relative card p-2" style="border-color: var(--warna-keempat)">
                        <div class="p-0 position-relative">
                            <div class="position-absolute bottom-0 top-0 end-0 d-flex justify-content-center align-items-center" style="width: 100%; background-color: rgba(0, 0, 0, 0.7); color: white; padding: 10px; "><h1>STOK HABIS</h1></div>
                            <img src="{{asset('storage/'.$item->foto)}}" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                        </div>
                        <div class="card-body p-0 mt-2">
                            <div class="d-flex justify-content-between">
                                <h2 class="card-title fw-bold color-keempat">{{$item->nama}}</h2>
                                <h3 class="card-title fw-medium color-keempat">{{ $item->kategori->nama }}</h3>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                {{-- <p class="card-text text-success"><strong>Rp 0</strong></p> --}}
                                <p>&nbsp;</p>
                                <p></p>
                            </div>
                            <div class="d-flex gap-2">
                                <button disabled class="btn bg-keempat color-keempat fs-5 col-10">Pesan</button>
                                <button disabled class=" btn color-keempat w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-keempat)"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
                    <div class="position-relative card p-2" style="border-color: var(--warna-keempat)">
                        @if ($item->diskon > 0)
                            <span class="position-absolute badge bg-danger rounded-0 end-0 top-0 text-bg-warning fs-4 d-flex justify-content-center align-items-center" style="width: 50px; height:50px">{{$item->diskon}}%</span>
                        @endif
                        <div class="p-0">
                            <img src="{{asset('storage/'.$item->foto)}}" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                        </div>
                        <div class="card-body p-0 mt-2">
                            <div class="d-flex justify-content-between">
                                <h2 class="card-title fw-bold color-keempat">{{$item->nama}}</h2>
                                <h3 class="card-title fw-medium color-ketiga">{{ $item->kategori->nama }}</h3>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <p class="card-text text-success"><strong>Rp. {{ number_format($item->harga * (1 - $item->diskon / 100), 0, ',', '.') }}</strong></p>
                                @if ($item->diskon > 0)
                                <p class="card-text text-danger"><small><del>Rp. {{ number_format($item->harga, 0, ',', '.') }}</del></small></p>
                                @endif
                                <p></p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn bg-kedua color-keempat fs-5 col-10 pesan" data-url="{{route('cart')}}" id="pesan" data-id="{{$item->id}}">Pesan</button>
                                <button id="detail" class="detail btn color-keempat w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-data="{{$item}}"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
        @else
            <h1 class="color-keempat text-center">Data Produk Belum Tersedia, Nantikan info Terbarunya!</h1>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="productModalLabel1" class="text-center w-100 color-utama"></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="productImage" style="height: 400px; object-fit:cover" src="" alt="Product Image" class="rounded img-fluid  mb-3 w-100">
                <h5 class="modal-title mb-3 color-utama" id="productModalLabel"></h5>
                <div class="d-flex gap-2 flex-wrap">
                    <p class="card-text text-success"><strong id="productHargaDiskon"></strong></p>
                    <p class="card-text text-danger" id="disc"><small><del id="productHarga"></del></small></p>
                </div>
                <p id="productDescription" class="color-utama mb-3"></p>
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
                maximumFractionDigits: 0  // Tidak menampilkan angka di belakang koma
            }).format(amount);
        }

        function calculateDiscountedPrice(originalPrice, discountPercentage) {
            return originalPrice - (originalPrice * (discountPercentage / 100));
        }

       
        $(document).ready(function(){
            const pesanButton = $('.pesan');
            const addToCart = $('.addToCart');
            
            pesanButton.on('click', function (event) {
                event.preventDefault();
                const id = $(this).data('id')
                cekAuthUser('menu', 'add', id)
                
            });
            addToCart.on('click', function (event) {
                event.preventDefault();
                const id = $(this).data('id')
                cekAuthUser('menu', 'add', id)
                $('#productModal').modal('hide');
            });

            $('.detail').on('click', function(){
                const data = $(this).data('data');

                console.log('data', data.id)
                $('#addToCart').attr('data-id', data.id);
                $('#productImage').attr('src', '{{asset("storage")}}/' + data.foto);
                $('#productModalLabel1').text(data.nama);
                $('#productModalLabel').text(data.nama);
                $('#productDescription').text(data.deskripsi);
                $('#productHargaDiskon').text(formatCurrencyIDR(calculateDiscountedPrice(data.harga, data.diskon)));
                $('#productHarga').text(formatCurrencyIDR(data.harga));
                if(formatCurrencyIDR(data.harga) == formatCurrencyIDR(calculateDiscountedPrice(data.harga, data.diskon))){
                    $('#disc').attr('hidden', 'true');
                }else{
                    $('#disc').removeAttr('hidden');
                }
                $('#productModal').modal('show');
            })
            
        })
        
    </script>
@endpush