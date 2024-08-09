@extends('welcome')

@section('title', 'Cart')
@section('content')
    <section class=" container">
        <div class="d-flex justify-content-center">
            <div style="width:500px">
                <div class="row ">
                    @foreach ($keranjangs as $keranjang)
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="row g-0 d-flex">
                                    <div class="col-4 d-flex justify-content-start align-items-center">
                                        <img src="{{ $keranjang->menu->foto }}"
                                            style="width: 150px; height: 150px; object-fit:cover"
                                            class="img-fluid m-1 rounded" alt="...">
                                    </div>
                                    <div class="col-6">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $keranjang->menu->nama }}</h5>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <p class="card-text text-success"><strong>Rp.
                                                        {{ number_format($keranjang->menu->harga * (1 - $keranjang->menu->diskon / 100), 0, ',', '.') }}</strong>
                                                </p>
                                                <p class="card-text text-danger"><small><del>Rp.
                                                            {{ number_format($keranjang->menu->harga, 0, ',', '.') }}</del></small>
                                                </p>
                                            </div>
                                            <div class="card-text d-flex justify-content-center gap-4 align-items-center">
                                                <i class="fa-solid fa-minus p-1 border border-1 rounded-circle"></i>
                                                <div>{{ 1 }}</div>
                                                <i class="fa-solid fa-plus p-1 border border-1 rounded-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 d-flex justify-content-center align-items-center">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="d-flex justify-content-center align-items-center col-12 py-2 flex-column">
                        <div class="total d-flex justify-content-end w-100 fs-3 fw-bold text-end">
                            Rp {{ number_format($keranjangs->sum(fn($k) => $k->menu->harga * (1 - $k->menu->diskon / 100)), 0, ',', '.') }}
                        </div>
                        <form action="{{ route('pesanan.checkout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn bg-kedua color-utama w-100">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
