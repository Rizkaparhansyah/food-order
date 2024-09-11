@extends('welcome')

@section('title', 'Cart')
@section('content')
    <section class="container">
        <div class="d-flex justify-content-center">
            <div style="width:500px">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('pesanan.checkout') }}" method="POST" class="w-100">
                    @csrf
                    <div class="row">
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
                                                <div
                                                    class="card-text d-flex justify-content-center gap-4 align-items-center">
                                                    <!-- Minus Button -->
                                                    <span onclick="changeQuantity({{ $keranjang->id }}, -1)">
                                                        <i class="fa-solid fa-minus p-1 border border-1 rounded-circle"></i>
                                                    </span>
                                                    <!-- Quantity Display -->
                                                    <div id="quantity-{{ $keranjang->id }}">{{ $keranjang->jumlah }}</div>
                                                    <!-- Plus Button -->
                                                    <span onclick="changeQuantity({{ $keranjang->id }}, 1)">
                                                        <i class="fa-solid fa-plus p-1 border border-1 rounded-circle"></i>
                                                    </span>

                                                </div>
                                                <!-- Hidden Input for Quantity -->
                                                <input type="hidden" name="quantities[{{ $keranjang->id }}]"
                                                    id="input-quantity-{{ $keranjang->id }}"
                                                    value="{{ $keranjang->jumlah }}">
                                            </div>
                                        </div>
                                        <div class="col-2 d-flex justify-content-center align-items-center">
                                            <button type="button" class="btn btn-link p-0 m-0"
                                                onclick="deleteCartItem({{ $keranjang->id }})">
                                                <i class="fa-solid fa-trash text-danger" style="font-size: 1.2rem;"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row g-0 d-flex">
                                        <!-- Catatan untuk setiap item -->
                                        <input class="form-control mt-2" type="text"
                                            name="catatan[{{ $keranjang->id }}]" placeholder="Masukan Catatan disini.."
                                            value="{{ old('catatan.' . $keranjang->id) }}" />
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="row">
                            <div class="d-flex justify-content-center align-items-center col-12 py-2 flex-column">
                                <div class="total d-flex justify-content-end w-100 fs-3 fw-bold text-end">
                                    <div class="row">
                                        <table>
                                            <tbody>
                                                @foreach ($keranjangs as $keranjang)
                                                    <tr class="border-bottom fs-5 fw-normal">
                                                        <td class="ps-5">{{ $keranjang->menu->nama }}</td>
                                                        <td class="ps-5">x{{ $keranjang->jumlah }}</td>
                                                        <td class="ps-5">Rp.
                                                            {{ number_format($keranjang->menu->harga * $keranjang->jumlah, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td>
                                                    <td colspan="2" class="text-end fs-5 fw-normal text-danger">
                                                        Total Diskon : - Rp.
                                                        {{ number_format($keranjangs->sum(fn($k) => $k->menu->harga * ($k->menu->diskon / 100) * $k->jumlah), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end text-success">
                                                        Rp
                                                        {{ number_format($keranjangs->sum(fn($k) => $k->menu->harga * (1 - $k->menu->diskon / 100) * $k->jumlah), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end text-danger fs-5">
                                                        Hemat -Rp.
                                                        {{ number_format($keranjangs->sum(fn($k) => $k->menu->harga * ($k->menu->diskon / 100) * $k->jumlah), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="submit" class="btn bg-kedua color-utama w-100">Checkout</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- JavaScript to handle quantity change -->
    <script>
        function changeQuantity(id, delta) {
            const quantityDiv = document.getElementById(`quantity-${id}`);
            const quantityInput = document.getElementById(`input-quantity-${id}`);
            let currentQuantity = parseInt(quantityDiv.innerText);

            if (currentQuantity + delta > 0) {
                currentQuantity += delta;
                quantityDiv.innerText = currentQuantity;
                quantityInput.value = currentQuantity;

                if (delta > 0) {
                    plusCartItem(id);
                } else {
                    minCartItem(id);
                }
            }
        }

        function deleteCartItem(id) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                fetch(`/cart/${id}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        location.reload(); // Refresh halaman setelah item dihapus
                    } else {
                        alert('Gagal menghapus item.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            }
        }

        function plusCartItem(id) {
            fetch(`/cart/${id}/plus`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).then(response => {
                if (response.ok) {
                    location.reload(); // Refresh halaman setelah item dihapus
                } else {
                    alert('Terjadi kesalahan');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }

        function minCartItem(id) {
            fetch(`/cart/${id}/min`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).then(response => {
                if (response.ok) {
                    location.reload(); // Refresh halaman setelah item dihapus
                } else {
                    alert('Terjadi kesalahan');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
@endsection
