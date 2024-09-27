<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        {{-- Font icon --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <style>
            @font-face {
                font-family: 'quesha';
                src: url({{asset('font/Quesha-gndR.ttf')}});
            }
            :root{
                --warna-utama : #F8EDE3;
                --warna-kedua : #DFD3C3;
                --warna-ketiga : #D0B8A8;
                --warna-keempat : #8D493A;
            }
            a {
                color: black;
            }
            .bg-utama {
                background-color: var(--warna-utama)
            }
            .bg-kedua {
                background-color: var(--warna-kedua)
            }
            .bg-ketiga {
                background-color: var(--warna-ketiga)
            }
            .bg-keempat {
                background-color: var(--warna-keempat)
            }
            
            .color-utama {
                color: var(--warna-utama)
            }
            .color-kedua {
                color: var(--warna-utama)
            }
            .color-ketiga {
                color: var(--warna-ketiga)
            }
            .color-keempat {
                color: var(--warna-keempat)
            }

            body {
                font-family: 'quesha';
                color: var(--warna-keempat)
            }

        </style>
        @stack('css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body class="antialiased">
       
        <script> 
            // Set CSRF token in AJAX setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const addToCart = id => {
                $.ajax({
                    url: '{{ route('cart.add') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data:{
                        id: id,
                        qty: 1,
                    },

                    success: function(response) {
                        alertSwal('success', 'Berhasil', 'Berhasil masukan ke keranjang',"top-end", 500)
                        console.log('response', response)
                        // $('#cartCount').text(response.count);
                    },
                    error: function(xhr, status, error) {
                        alertSwal('error', 'Gagal!', 'Item gagal ditambahkan ke keranjang.');
                    }
                });
            }
            
            const cekAuthUser = (url, add, id) => {
                $.ajax({
                    url: '{{ route('check.auth') }}',
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    beforeSend: function(){
                        if(add == 'add'){
                            $('.pesan').attr('disabled', true)
                            // addToCart(id);
                        }
                    },
                    success: function (data) {
                        $('.pesan').attr('disabled', false)
                        // console.log('data', data)
                        if (!data.authenticated) {
                            $('#authModal').modal('show');
                        } else {
                            if(add == 'add'){
                                addToCart(id);
                            }else{
                                window.location.href = url;
                            }
                        }
                    }
                });
            }
            
            const alertSwal = (icon, title, message, position,  timer=1000) => {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: message,
                    showConfirmButton: false,
                    timer: timer,
                    position: position
                });
            };
            

            $(document).ready(function() {
        
                $('#logUser').on('click', function (event) {
                    const name = $('#namaUser').val();
                    const kode = $('#kodeUser').val();
                    console.log(name)
                    console.log(kode)
                    event.preventDefault();
                    $.ajax({
                        url: '{{ route('user.login') }}',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        data: JSON.stringify({ name: name,kode: kode, }),
                        success: function (data) {
                            console.log('data', data)
                            if (data.authenticated) {
                                $('#authModal').modal('hide');
                                window.location.href = '{{ route('cart') }}';
                            } else {
                                alert('Failed to login');
                            }
                        },
                        errors: function (data) {
                            alert('Gagal login!')
                        }
                    });
                })

            });
        </script>

        <x-navbar-component/>
        <x-modal-login-user/>
        <x-user-auth/>

        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 99;">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto color-utama" >Berhasil</strong>
                <small class="color-utama">Badami</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body color-utama">
                Berhasil memasukan produk ke keranjang!
              </div>
            </div>
        </div>

         @yield('content')


         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        @stack('script')
    </body>
</html>
