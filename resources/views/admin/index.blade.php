@extends('admin.base')

@section('title', 'ADMIN')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Total Orders Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-receipt fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text display-4">1,234</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-box fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Products</h5>
                        <p class="card-text display-4">567</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Customers Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-users fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Customers</h5>
                        <p class="card-text display-4">890</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-rupiah-sign fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="card-text display-4">1.200.345</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
