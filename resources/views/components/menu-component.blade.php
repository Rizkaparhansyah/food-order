@extends('welcome')

@section('title', 'Menu')
@section('content')
<x-filter-component/>
<div class="container mt-3">
    <div class="d-flex gap-3 flex-wrap">
        <div class="card" style="width: 18rem;">
            <div class="p-1">

                <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"  style=" height: 300px; object-fit:cover" class="card-img-top rounded" alt="...">
            </div>
                <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title fw-bold">Redvelvet</h4>
                    <h6 class="card-title fw-medium ">Minuman</h6>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <p class="card-text text-success"> <strong>Rp. 70.999</strong></p>
                    <p class="card-text  text-danger"> <small><del>Rp. 99.999</del></small></p></div>
            <div class="d-flex justify-content-between gap-1">
                <button class="btn bg-kedua color-utama col-9 fs-5">Pesan</button>
                <button class="btn color-utama col-2 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection