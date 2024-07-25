<div class="sidebar d-flex flex-column flex-shrink-0 p-3">
    <a href="/"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-light text-decoration-none ps-2 fw-bold">
        <span class="fs-4">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto text-white">
        <li class="nav-item sidebar-active">
            <a href="#" class="nav-link link-light d-flex align-items-center" aria-current="page">
                <i class="fas fa-home me-2 icon-size"></i>
                Dashboard
            </a>
        </li>
        <li class="my-2">
            <a href="#" class="nav-link link-light d-flex align-items-center">
                <i class="fas fa-table-list me-2 icon-size"></i>
                Daftar Pesanan
            </a>
        </li>
        <li class="my-2">
            <a href="#" class="nav-link link-light d-flex align-items-center">
                <i class="fas fa-utensils me-2 icon-size"></i>
                Menu
            </a>
        </li>
        <li class="my-2">
            <a href="#" class="nav-link link-light d-flex align-items-center">
                <i class="fas fa-layer-group me-2 icon-size"></i>
                Kategori
            </a>
        </li>
        <li class="my-2">
            <a href="#" class="nav-link link-light d-flex align-items-center">
                <i class="fas fa-sack-dollar me-2 icon-size"></i>
                Omset
            </a>
        </li>
        <li class="my-2">
            <a href="#" class="nav-link link-light d-flex align-items-center">
                <i class="fas fa-users me-2 icon-size"></i>
                Management User
            </a>
        </li>
    </ul>
    <hr>
    <div class="text-center">
        <a href="{{ route('auth.logout') }}" class="link-light fw-bold text-decoration-none">
            <i class="fas fa-sign-out-alt me-2"></i>LOGOUT
        </a>
    </div>
</div>
