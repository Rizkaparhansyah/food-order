      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand my-3 d-flex align-items-center justify-content-center" href="/">

          <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-money-bill-wave"></i>
          </div>
          <div class="sidebar-brand-text mx-3">
            @yield('title', 'BADAMI CAFE')
          </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
          <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Data
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Daftar Pesanan</span>
          </a>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Order</span>
          </a>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Riwayat</span>
          </a>

        <div class="text-center d-none d-md-inline">
          {{-- <br>
          <button class="rounded-sm border-0" id="sidebarToggle"></button> --}}
        </div>
      </ul>