<!-- Sidebar -->

@php
 // Contoh array konfigurasi menu di sidebar
$menuItems = [
    'admin' => [
        ['name' => 'Daftar Pesanan', 'route' => 'pesanan.list', 'icon' => 'fa fa-list'],
        ['name' => 'Order', 'route' => 'order.index', 'icon' => 'fa-cart-shopping'],
        ['name' => 'Menu', 'route' => 'list.menu', 'icon' => 'fa fa-list'],
        ['name' => 'Kategori', 'route' => 'list.kategori', 'icon' => 'fa fa-barcode'],
        ['name' => 'Data Penjualan', 'route' => 'data.penjualan', 'icon' => 'fa fa-history'],
        ['name' => 'Pesanan Pembelian', 'route' => 'admin.pembelian.index', 'icon' => 'fa fa-list'],
        ['name' => 'Penerimaan Barang', 'route' => 'admin.penerimaan.index', 'icon' => 'fa fa-list'],
        ['name' => 'Bahan Baku', 'route' => 'admin.bahan.index', 'icon' => 'fa fa-list'],
        ['name' => 'Manajemen User', 'route' => 'data.user', 'icon' => 'fa fa-user'],
    ],
    'kasir' => [
        ['name' => 'Daftar Pesanan', 'route' => 'kasir.pesanan.list', 'icon' => 'fa fa-list'],
        ['name' => 'Order', 'route' => 'kasir.order.index', 'icon' => 'fa fa-cart-shopping'],
        ['name' => 'Menu', 'route' => 'kasir.list.menu', 'icon' => 'fa fa-list'],
        ['name' => 'Kategori', 'route' => 'kasir.list.kategori', 'icon' => 'fa fa-barcode'],
        ['name' => 'Data Penjualan', 'route' => 'kasir.data.penjualan', 'icon' => 'fa fa-history'],
    ],
];

    $role = Auth::user()->role; // Asumsi peran disimpan di kolom 'role'
   
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{Auth::user()->role}}</div>
    </a>
    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{route(Auth::user()->role == 'admin' ? 'admin' : 'kasir') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <div class="sidebar-heading">
        Interface
    </div>

    @foreach ($menuItems[$role] as $menuItem)
        <li class="nav-item">
            <a class="nav-link" href="{{ route($menuItem['route']) }}">
                <i class="fas fa-fw {{ $menuItem['icon'] }}"></i>
                <span>{{ $menuItem['name'] }}</span></a>
        </li>
    @endforeach

   
{{-- 
    <li class="nav-item">
        <a class="nav-link" href="{{ route('order.index') }}">
            <i class="fas fa-fw fa-cart-shopping"></i>
            <span>Order</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('list.menu') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Menu</span></a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="{{ route('list.kategori') }}">
            <i class="fas fa-fw fa-barcode"></i>
            <span>Kategori</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('data.penjualan')}}">
            <i class="fas fa-fw fa-history"></i>
            <span>Data Penjualan</span></a>
    </li>
    
    @if(Auth::user()->role != 'kasir')
    <li class="nav-item">
        <a class="nav-link" href="{{url('pembelian-barang')}}">
            <i class="fas fa-fw fa-history"></i>
            <span>Pesanan Pembelian</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{url('penerimaan-barang')}}">
            <i class="fas fa-fw fa-history"></i>
            <span>Penerimaan Barang</span></a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{url('bahan-baku')}}">
            <i class="fas fa-fw fa-history"></i>
            <span>Bahan Baku</span></a>
        </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('data.user')}}">
            <i class="fas fa-fw fa-user"></i>
            <span>Management User</span>
        </a>
    </li>
@endif --}}
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
        
