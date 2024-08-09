@extends('welcome')

@section('title', 'Menu')
@section('content')

<x-filter-component/>

<div class="container mt-3">
    <div class="row">
        @foreach ($data as $item)
            <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
                <div class="card p-2">
                    <div class="p-0">
                        <img src="{{$item->foto}}" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                    </div>
                    <div class="card-body p-0 mt-2">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title fw-bold">{{$item->nama}}</h2>
                            <h3 class="card-title fw-medium">{{ $item->kategori->nama }}</h3>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <p class="card-text text-success"><strong>Rp. {{ number_format($item->harga * (1 - $item->diskon / 100), 0, ',', '.') }}</strong></p>
                            <p class="card-text text-danger"><small><del>Rp. {{ number_format($item->harga, 0, ',', '.') }}</del></small></p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn bg-kedua color-utama fs-5 col-10 add-to-cart-btn" data-id="{{$item->id}}" data-nama="{{$item->nama}}" data-foto="{{$item->foto}}" data-harga="{{$item->harga}}" data-diskon="{{$item->diskon}}">Pesan</button>
                            <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
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
                <img id="productImage" style="height: 400px; object-fit:cover" src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Product Image" class="rounded img-fluid mb-3 w-100">
                <h5 class="modal-title mb-3" id="productModalLabel">Redvelvet</h5>
                <p id="productDescription" class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime, rem iste libero exercitationem natus eos minus fugit ipsum ullam iusto facilis suscipit dolore explicabo doloremque ipsa error numquam beatae deserunt dicta in recusandae qui.</p>
                <button class="btn bg-kedua color-utama w-100" id="addToCart">
                    <i class="fa-solid fa-cart-shopping color-utama me-2"></i> Keranjang
                </button>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const item = {
                id: this.dataset.id,
                nama: this.dataset.nama,
                foto: this.dataset.foto,
                harga: parseFloat(this.dataset.harga),
                diskon: parseFloat(this.dataset.diskon),
                quantity: 1
            };
            addToCart(item);
        });
    });

    function addToCart(item) {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const existingItemIndex = cartItems.findIndex(i => i.id === item.id);
        
        if (existingItemIndex > -1) {
            cartItems[existingItemIndex].quantity += 1;
        } else {
            cartItems.push(item);
        }

        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateCart();
    }

    function updateCart() {
        alert('Pesanan ditambahkan ke keranjang');
    }
});
</script>
@endpush
