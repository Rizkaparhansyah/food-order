@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('order.search') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="query" placeholder="Cari menu" aria-label="Search" aria-describedby="button-search" value="{{ request()->query('query') }}">
                            <button class="btn btn-outline-secondary" type="submit" id="button-search">Search</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="container mt-1">
                        <div class="row">
                            @forelse ($data as $item)
                                <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
                                    <div class="card p-2 position-relative">
                                        <div class="card-img-container">
                                            <img src="{{ asset($item->foto) }}" style="height: 200px; object-fit: cover" class="col-sm-12 card-img-top rounded" alt="{{ $item->nama }}">
                                            @if ($item->stok <= 0)
                                                <div class="out-of-stock-overlay">STOK HABIS</div>
                                            @endif
                                        </div>
                                        <div class="card-body p-0 mt-2">
                                            <div class="d-flex justify-content-between">
                                                <h4 class="card-title fw-bold">{{ $item->nama }}</h4>
                                            </div>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <p class="card-text text-success"><strong>Rp. {{ number_format($item->harga * (1 - $item->diskon / 100), 0, ',', '.') }}</strong></p>
                                            </div>
                                            <div class="d-flex gap-2">
                                                @if ($item->stok > 0)
                                                    <form action="{{ route('order.addToCart', $item->id) }}" method="POST">
                                                        @csrf
                                                        <button class="btn btn-primary fs-5 col-12" type="submit">Pesan</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary fs-5 col-12" disabled>Pesan</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-center">Tidak ada item menu yang ditemukan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Keranjang
                </div>
                <div class="card-body">
                    @if (Session::has('cart'))
                        <ul class="list-group">
                            @foreach (Session::get('cart') as $id => $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <img src="{{ asset($item['foto']) }}" style="height: 50px; object-fit: cover" alt="{{ $item['name'] }}">
                                    <div>
                                        {{ $item['name'] }} x {{ $item['quantity'] }}
                                        <br>
                                        Rp. {{ number_format($item['price'], 0, ',', '.') }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <form action="{{ route('order.checkout') }}" method="POST" class="mt-3">
                            @csrf
                            <button class="btn btn-success col-12" type="submit">Checkout</button>
                        </form>
                    @else
                        <p>Keranjang kosong.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
