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

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


        {{-- Font icon --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <style>
            @font-face {
                font-family: 'quesha';
                src: url({{asset('font/Quesha-gndR.ttf')}});
            }
            :root{
                --warna-utama : #F8F4E1;
                --warna-kedua : #AF8F6F;
                --warna-ketiga : #74512D;
                --warna-keempat : #543310;
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
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body class="antialiased">
       

        <x-navbar-component/>
        <x-user-auth :mejas="$mejas"/>
         @yield('content')


        <script> 
        
            // Set CSRF token in AJAX setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            window.cekAuthUser = url => {
                $.ajax({
                    url: '{{ route('check.auth') }}',
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    success: function (data) {
                        // console.log('data', data)
                        if (!data.authenticated) {
                            $('#authModal').modal('show');
                        } else {
                            window.location.href = url;
                        }
                    }
                });
            }
            
            $(document).ready(function() {
                const nameLoginModal = new bootstrap.Modal(document.getElementById('authModal'));
                const cartButton = $('#cart');
                const pesanButton = $('#pesan');
                const nameLoginForm = $('#formUser');

               

                $('#logoutButton').on('click', function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: '{{ route('logout.user') }}',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        success: function (data) {
                            if (!data.authenticated) {
                                $('#logoutButton').attr('hidden', true)
                                alert('berhasil.');
                                window.location.href = '/'; // Redirect ke halaman yang diinginkan
                            } else {
                                alert('Logout failed.');
                            }
                        }
                    });
                });

                
                cartButton.on('click', function (event) {
                    event.preventDefault();
                    const url = $(this).data('url')
                    cekAuthUser(url)
                });

                pesanButton.on('click', function (event) {
                    event.preventDefault();
                    const url = $(this).data('url')
                    cekAuthUser(url)
                });

                nameLoginForm.on('submit', function (event) {
                    event.preventDefault();
                    const name = $('#namaUser').val();
                    const meja = $('#meja').val();

                    $.ajax({
                        url: '{{ route('user.login') }}',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        data: JSON.stringify({ name: name, meja: meja  }),
                        success: function (data) {
                            
                            if (data.authenticated) {
                                nameLoginModal.hide();
                                window.location.href = '{{ route('cart') }}';
                            } else {
                                alert('Failed to login');
                            }
                        },
                        errors: function (data) {
                            alert('Gagal login!')
                        }
                    });
                });
             
            });
        </script>

        @stack('script')

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>