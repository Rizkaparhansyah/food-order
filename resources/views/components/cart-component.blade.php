@extends('welcome')

@section('title', 'Cart')
@section('content')
<section class="container">
    <div class="d-flex justify-content-center">
        <div style="width:500px">
            <div class="row" id="cart-items">
                <!-- Cart items will be dynamically added here -->
            </div>
            <div class="row">
                <div class="d-flex justify-content-center align-items-center col-12 py-2 flex-column">
                    <div class="total d-flex justify-content-end w-100 fs-3 fw-bold text-end">Rp 0</div>
                    <input type="text" id="customer-name" class="form-control my-3" placeholder="Masukkan Nama Pemesan">
                    <button id="checkout-button" class="btn bg-kedua color-utama w-100">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartItemsContainer = document.getElementById('cart-items');
    const checkoutButton = document.getElementById('checkout-button');

    function loadCartItems() {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartItemsContainer.innerHTML = '';

        cartItems.forEach(item => {
            const discountPrice = item.harga * (1 - item.diskon / 100);
            const itemHTML = `
                <div class="col-12 cart-item" data-id="${item.id}">
                    <div class="card mb-3">
                        <div class="row g-0 d-flex">
                            <div class="col-4 d-flex justify-content-start align-items-center">
                                <img src="${item.foto}" class="img-fluid m-1 rounded" alt="${item.nama}" style="width: 150px; height: 150px; object-fit:cover">
                            </div>
                            <div class="col-6">
                                <div class="card-body">
                                    <h5 class="card-title">${item.nama}</h5>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <p class="card-text text-success"><strong>Rp. ${discountPrice.toLocaleString('id-ID')}</strong></p>
                                        <p class="card-text text-danger"><small><del>Rp. ${item.harga.toLocaleString('id-ID')}</del></small></p>
                                    </div>
                                    <div class="card-text d-flex justify-content-center gap-4 align-items-center">
                                        <i class="fa-solid fa-minus p-1 border border-1 rounded-circle quantity-decrease"></i>
                                        <div class="quantity">${item.quantity}</div>
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
            `;
            cartItemsContainer.insertAdjacentHTML('beforeend', itemHTML);
        });

        updateTotalPrice();
    }

    function updateTotalPrice() {
        let totalPrice = 0;
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

        cartItems.forEach(item => {
            const discountPrice = item.harga * (1 - item.diskon / 100);
            totalPrice += discountPrice * item.quantity;
        });

        document.querySelector('.total').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }

    cartItemsContainer.addEventListener('click', function(event) {
        const target = event.target;
        const cartItem = target.closest('.cart-item');

        if (cartItem) {
            const id = cartItem.dataset.id;
            const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
            const itemIndex = cartItems.findIndex(i => i.id == id);
            const quantityElement = cartItem.querySelector('.quantity');
            let quantity = parseInt(quantityElement.textContent);

            if (target.classList.contains('quantity-increase')) {
                quantity += 1;
            } else if (target.classList.contains('quantity-decrease')) {
                quantity = quantity > 1 ? quantity - 1 : 1;
            } else if (target.classList.contains('remove-item')) {
                cartItems.splice(itemIndex, 1);
                cartItem.remove();
            }

            if (itemIndex > -1) {
                cartItems[itemIndex].quantity = quantity;
            }

            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            quantityElement.textContent = quantity;
            updateTotalPrice();
        }
    });

    checkoutButton.addEventListener('click', function() {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const customerName = document.getElementById('customer-name').value.trim();

        if (cartItems.length === 0) {
            alert('Keranjang belanja kosong.');
            return;
        }

        if (!customerName) {
            alert('Silakan masukkan nama pemesan.');
            return;
        }

        cartItems.forEach(item => {
            fetch('{{ route('pesanan.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nama_pelanggan: customerName,
                    id_menu: item.id,
                    jumlah: item.quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert('Pesanan berhasil dibuat');
                } else {
                    alert('Terjadi kesalahan saat membuat pesanan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat membuat pesanan');
            });
        });

        // Clear the cart after checkout
        localStorage.removeItem('cartItems');
        loadCartItems();
    });

    loadCartItems();
});
</script>
@endsection
