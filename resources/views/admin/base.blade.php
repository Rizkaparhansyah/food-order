<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ADMIN</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- Font icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @font-face {
            font-family: 'quesha';
            src: url({{ asset('font/Quesha-gndR.ttf') }});
        }

        :root {
            --warna-utama: #F8F4E1;
            --warna-kedua: #AF8F6F;
            --warna-ketiga: #74512D;
            --warna-keempat: #543310;
        }

        body {
            font-family: 'quesha';
            display: flex;
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

        #app {
            display: flex;
            width: 100%;
        }

        .flex-grow-1 {
            flex-grow: 1;
        }

        .sidebar-active {
            font-weight: bold;
            color: white;
            background-color: var(--warna-keempat)
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 280px;
            padding-top: 60px;
            overflow-x: hidden;
            overflow-y: auto;
            background-color: var(--warna-ketiga);
            color: white;
        }

        .icon-size {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-link:hover {
            background-color: var(--warna-keempat);
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div id="app" class="d-flex">
        <x-admin-sidebar />
        <div class="flex-grow-1" style="margin-left: 280px;">
            <x-admin-navbar />
            <div class="container mt-4">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
