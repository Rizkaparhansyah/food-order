<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
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

            .btn-purple {
            background-color: #6f42c1;
            color: #fff;
            border: none;
            }

        </style>
    </head>
    <body class="antialiased">
       

        <x-navbar-component/>
         @yield('content')


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
