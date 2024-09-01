

@extends('welcome')

@section('title', 'Cart')
@section('content')
  <section class="container">
    <div class="d-flex justify-content-center">
      <div style="width:500px">
        <form id='keranjangCheckout'>
          <div id="cart-items" class="row"></div>
          <div class="row">
            <div class="d-flex justify-content-center align-items-center col-12 py-2 flex-column">
              <div class="total d-flex justify-content-end w-100 text-end">
                <div class="w-50" id="order-summary"></div>
              </div>
              <div class="total d-flex justify-content-end w-100 fs-3 fw-bold text-end text-success" id="total-price"></div>
              <div class="total d-flex justify-content-end w-100 fs-6 fw-bold text-end text-danger" id="total-savings"></div>
              <button id="checkout-button" class="btn bg-kedua color-keempat w-100 cekot" disabled>Checkout</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection

@push('script')
<script>
  $(document).ready(function() {


    const FormatRupiah = num => {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      }).format(num);
    }
    

    function fetchCartData() {
      $.ajax({
        url: '{{ route("cart.get") }}', // Route to fetch cart data
        method: 'GET',
        success: function(data) {
          renderCartItems(data);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching cart data:', error);
        }
      });
    }
    let totalItemPrice = 0;
    function renderCartItems(data) {
      let totalPrice = 0;
      let cartItemsContainer = $('#cart-items');
      let orderSummaryContainer = $('#order-summary');
      let totalPriceContainer = $('#total-price');
      let totalSavingsContainer = $('#total-savings');
      let totalSavings = 0;

      cartItemsContainer.empty();
      orderSummaryContainer.empty();

      data.forEach(item => {
        let discountedPrice = item.menu.harga * (1 - item.menu.diskon / 100);
        totalItemPrice = discountedPrice * item.qty;
        totalPrice += totalItemPrice;
        totalSavings += (item.menu.harga * item.qty) - totalItemPrice;

        let cartItemHTML = `
          <div class="col-12" id="cartTotal">
            <input type="hidden" name="id_menu" class="id_menu" value="${item.id_menu}">
            <input type="hidden" name="qty" class="qty" value="${item.qty}">
            <div class="card mb-3">
              <div class="row g-0 d-flex">
                <div class="col-4 d-flex justify-content-start align-items-center">
                  <img src="{{ asset('storage') }}/${item.menu.foto}" class="img-fluid m-1 rounded" alt="..." style="width: 150px; height: 150px; object-fit:cover">
                </div>
                <div class="col-6">
                  <div class="card-body">
                    <p class="card-title fs-2 font-weight-bold color-utama">${item.menu.nama}</p>
                    <div class="d-flex gap-2 flex-wrap">
                      <p class="card-text text-success">
                        <strong> ${FormatRupiah(totalItemPrice)}</strong>
                      </p>
                      <p class="card-text text-danger"><small><del> ${FormatRupiah(item.menu.harga * item.qty)}</del></small></p>
                    </div>
                    <div class="card-text d-flex justify-content-center gap-4 align-items-center">
                      <i data-id="${item.menu.id}"  data-qty="${item.qty}" class="fa-solid fa-minus p-1 border border-1 rounded-circle minqty color-utama"></i>
                      <div class=" color-utama">${item.qty}</div>
                      <i data-id="${item.menu.id}" data-qty="${item.qty}" class="fa-solid fa-plus p-1 border border-1 rounded-circle plusqty color-utama"></i>
                    </div>
                  </div>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center hapusCart" data-id="${item.id_menu}">
                  <i class="fa-solid fa-trash text-danger"></i>
                </div>
              </div>
              
            <input type="text" class="form-control form-control-lg rounded-0 rounded-bottom border-top-" name="catatan" placeholder="Jangan terlalu manis ya cheff😉"/>
            </div>
          </div>
        `;
        cartItemsContainer.append(cartItemHTML);

        let orderSummaryHTML = `
          <div class="row align-items-center border-bottom">
            <div class="col-md-4"><p class="mb-0 text-start color-utama">${item.menu.nama}</p></div>
            <div class="col-md-4 text-center"><p class="mb-0 color-utama">x${item.qty}</p></div>
            <div class="col-md-4 text-right"><p class="mb-0 color-utama">${FormatRupiah(totalItemPrice)}</p></div>
          </div>
        `;
        orderSummaryContainer.append(orderSummaryHTML);
      });

      let totalSummaryHTML = `
        <div class="row align-items-center border-bottom">
          <div class="col-md-4"><p class="mb-0 text-start color-utama">Total Diskon</p></div>
          <div class="col-md-8 text-right"><p class="mb-0 color-utama">- ${FormatRupiah(totalSavings)}</p></div>
        </div>
      `;
      orderSummaryContainer.append(totalSummaryHTML);

      totalPriceContainer.text(`${FormatRupiah(totalPrice)}`);
      totalSavingsContainer.text(`hemat -${FormatRupiah(totalSavings)}`);
      $('#checkout-button').prop('disabled', totalPrice === 0);
    }

    

    $(document).on('click', '.hapusCart', function() {
      const id = $(this).data('id');
      $.ajax({
        url: '{{ route("cart.del") }}',
        method: 'post',
        data: {
          _token: '{{ csrf_token() }}',
          id: id,
        },
        success: function(response) {
          fetchCartData();
        }
      });
    });

    $(document).on('submit', '#keranjangCheckout', function(e) {
      e.preventDefault();

      // Membuat objek data yang akan dikirim
      var formData = {
          _token: '{{ csrf_token() }}',
          data: {}
      };

      // Mengambil nilai catatan dari input dengan name="catatan"

      $('.col-12').each(function() {
          var idMenu = $(this).find('.id_menu').val();
          var qty = $(this).find('.qty').val();
          var catatan = $(this).find('input[name="catatan"]').val();

          // Pastikan semua nilai ada sebelum menambahkannya ke data
          if (idMenu && qty) {
              formData.data[idMenu] = {
                  catatan: catatan,
                  qty: qty
              };
          }
      });

      // Debug output untuk melihat isi FormData
      

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: "btn btn-success",
              cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
          });
          swalWithBootstrapButtons.fire({
            title: "Apakah pesananmu sudah benar?",
            text: `Tolong siapkan uang anda untuk melakukan payment:)`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Benar!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url: '{{ route('checkout')}}',
                  type: 'POST',
                  data: formData,
                  success: function(response) {
                    swalWithBootstrapButtons.fire({
                      title: "Berhasil!",
                      text: "Silahkan cek proses pesanan anda!",
                      icon: "success"
                    });
                      location.reload()
                  },
                  error: function(xhr, status, error) {
                      console.error('Error:', error);
                  }
            });
             
            } 
        });

        
    });

    $(document).on('click', '.minqty', function() {
      var qty = $(this).data('qty')
        var id = $(this).data('id')
        if (qty > 1) {
          console.log('$qty ==> ' , qty - 1, '$id ==> ', id)
            updateCart(id, qty - 1);
        }
    });

    $(document).on('click', '.plusqty', function() {
        var qty = $(this).data('qty')
        var id = $(this).data('id')
        console.log('$qty ==> ' , qty + 1, '$id ==> ' + id)
        updateCart(id, qty + 1);
    });

    function updateCart($id, $qty) {
        // var idMenu = $qty.closest('.card-body').find('.id_menu').val();
        // var qty = $qty.val();
        var nama_pelanggan = 'nama_pelanggan'; // Ganti dengan nilai sebenarnya
        var kode = 'kode'; // Ganti dengan nilai sebenarnya

        $.ajax({
            url: '{{ route('cart.update') }}',
            method: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                id_menu: $id,
                qty: $qty,
            },
            success: function(response) {
                if (response.success) {
                    fetchCartData();
                } else {
                    alert(response.message);
                }
            }
        });
    }

    // Initial fetch
    fetchCartData();
  });
</script>
@endpush
