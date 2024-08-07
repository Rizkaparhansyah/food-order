@extends('welcome')

@section('title', 'Cart')
@section('content')
<section class="container">
    <div class="d-flex justify-content-center">
        <div style="width:500px">
            <div class="row" id="cart-items">
                <div class="col-12 cart-item" data-id="1">
                    <div class="card mb-3">
                        <div class="row g-0 d-flex">
                            <div class="col-4 d-flex justify-content-start align-items-center">
                                <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid m-1 rounded" alt="..." style="width: 150px; height: 150px; object-fit:cover">
                            </div>
                            <div class="col-6">
                                <div class="card-body">
                                    <h5 class="card-title">Redvelvet</h5>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <p class="card-text text-success"><strong>Rp. 70.999</strong></p>
                                        <p class="card-text text-danger"><small><del>Rp. 99.999</del></small></p>
                                    </div>
                                    <div class="card-text d-flex justify-content-center gap-4 align-items-center">
                                        <i class="fa-solid fa-minus p-1 border border-1 rounded-circle quantity-decrease"></i>
                                        <div class="quantity">1</div>
                                        <i class="fa-solid fa-plus p-1 border border-1 rounded-circle quantity-increase"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-trash text-danger remove-item"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tambahkan item lain dengan struktur yang sama di sini -->
            </div>
            <div class="row">
                <div class="d-flex justify-content-center align-items-center col-12 py-2 flex-column">
                    <div class="total d-flex justify-content-end w-100 fs-3 fw-bold text-end">Rp 99.999</div>
                    <div class="btn bg-kedua color-utama w-100">Checkout</div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.getElementById('cart-items');

    cartItems.addEventListener('click', function(event) {
        const target = event.target;
        const cartItem = target.closest('.cart-item');

        if (cartItem) {
            const quantityElement = cartItem.querySelector('.quantity');
            let quantity = parseInt(quantityElement.textContent);

            if (target.classList.contains('quantity-increase')) {
                quantity += 1;
            } else if (target.classList.contains('quantity-decrease')) {
                quantity = quantity > 1 ? quantity - 1 : 1;
            } else if (target.classList.contains('remove-item')) {
                cartItem.remove();
            }

            quantityElement.textContent = quantity;

            // Update total price here if needed
            updateTotalPrice();
        }
    });

    function updateTotalPrice() {
        let totalPrice = 0;
        const items = cartItems.querySelectorAll('.cart-item');

        items.forEach(item => {
            const priceElement = item.querySelector('.card-text.text-success strong');
            const quantityElement = item.querySelector('.quantity');
            const price = parseInt(priceElement.textContent.replace('Rp. ', '').replace('.', ''));
            const quantity = parseInt(quantityElement.textContent);
            totalPrice += price * quantity;
        });

        document.querySelector('.total').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }

    // Initial total price calculation
    updateTotalPrice();
});
</script>
@endsection
