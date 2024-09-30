<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>
    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('list-pesanan') }}">
            <i class="fas fa-fw fa-cart-shopping"></i>
            <span>Daftar Pesanan</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('list-menu') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Menu</span></a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="{{ route('list-kategori') }}">
            <i class="fas fa-fw fa-barcode"></i>
            <span>Kategori</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.bahanbaku.index') }}">
            <i class="fas fa-fw fa-barcode"></i>
            <span>Bahan Baku</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-history"></i>
            <span>Data Penjualan</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('order') }}">
            <i class="fas fa-fw fa-cart-shopping"></i>
            <span>Order</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('data.user') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Management User</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>