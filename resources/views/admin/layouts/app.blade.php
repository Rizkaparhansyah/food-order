<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">
    <title>Cafe</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link href="{{ asset('adm/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- SB Admin CSS -->
    <link href="{{ asset('adm/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
  
    @stack('css')
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                @include('admin.layouts.topbar')
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <!-- Footer -->
            @include('admin.layouts.footer')
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    @include('admin.layouts.logoutModal')

    <!-- jQuery -->
    <script src="{{ asset('adm/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap JavaScript -->
    <script src="{{ asset('adm/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery Easing -->
    <script src="{{ asset('adm/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- SB Admin Custom Scripts -->
    <script src="{{ asset('adm/js/sb-admin-2.min.js') }}"></script>
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    @stack('script')
</body>
</html>
