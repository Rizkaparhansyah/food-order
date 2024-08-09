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
                            <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal" data-id="{{$item->id}}" data-nama="{{$item->nama}}" data-foto="{{$item->foto}}" data-deskripsi="{{$item->deskripsi}}" data-harga="{{$item->harga}}"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="productImage" style="height: 400px; object-fit:cover" src="" alt="Product Image" class="rounded img-fluid mb-3 w-100">
                <h5 id="productName" class="mb-3"></h5>
                <p id="productDescription" class="mb-3"></p>
                <p id="productPrice" class="mb-3"></p>
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

    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const foto = this.dataset.foto;
            const deskripsi = this.dataset.deskripsi;
            const harga = this.dataset.harga;

            document.getElementById('productImage').src = foto;
            document.getElementById('productName').textContent = nama;
            document.getElementById('productDescription').textContent = deskripsi;
            document.getElementById('productPrice').textContent = 'Rp. ' + new Intl.NumberFormat('id-ID').format(harga);
            document.getElementById('addToCart').dataset.id = id;
            document.getElementById('addToCart').dataset.nama = nama;
            document.getElementById('addToCart').dataset.foto = foto;
            document.getElementById('addToCart').dataset.harga = harga;
            document.getElementById('addToCart').dataset.diskon = diskon;
        });
    });

    document.getElementById('addToCart').addEventListener('click', function() {
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
