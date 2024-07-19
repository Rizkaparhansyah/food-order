@extends('welcome')

@section('title', 'Menu')
@section('content')

<x-filter-component/>

<div class="container mt-3">
    <div class="row">
        <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
            <div class="card p-2">
                <div class="p-0">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title fw-bold">Redvelvet</h4>
                        <h6 class="card-title fw-medium">Minuman</h6>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"><strong>Rp. 70.999</strong></p>
                        <p class="card-text text-danger"><small><del>Rp. 99.999</del></small></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn bg-kedua color-utama fs-5 col-10">Pesan</button>
                        <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
            <div class="card p-2">
                <div class="p-0">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title fw-bold">Redvelvet</h4>
                        <h6 class="card-title fw-medium">Minuman</h6>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"><strong>Rp. 70.999</strong></p>
                        <p class="card-text text-danger"><small><del>Rp. 99.999</del></small></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn bg-kedua color-utama fs-5 col-10">Pesan</button>
                        <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
            <div class="card p-2">
                <div class="p-0">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title fw-bold">Redvelvet</h4>
                        <h6 class="card-title fw-medium">Minuman</h6>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"><strong>Rp. 70.999</strong></p>
                        <p class="card-text text-danger"><small><del>Rp. 99.999</del></small></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn bg-kedua color-utama fs-5 col-10">Pesan</button>
                        <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
            <div class="card p-2">
                <div class="p-0">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title fw-bold">Redvelvet</h4>
                        <h6 class="card-title fw-medium">Minuman</h6>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"><strong>Rp. 70.999</strong></p>
                        <p class="card-text text-danger"><small><del>Rp. 99.999</del></small></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn bg-kedua color-utama fs-5 col-10">Pesan</button>
                        <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
            <div class="card p-2">
                <div class="p-0">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title fw-bold">Redvelvet</h4>
                        <h6 class="card-title fw-medium">Minuman</h6>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"><strong>Rp. 70.999</strong></p>
                        <p class="card-text text-danger"><small><del>Rp. 99.999</del></small></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn bg-kedua color-utama fs-5 col-10">Pesan</button>
                        <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
            <div class="card p-2">
                <div class="p-0">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title fw-bold">Redvelvet</h4>
                        <h6 class="card-title fw-medium">Minuman</h6>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"><strong>Rp. 70.999</strong></p>
                        <p class="card-text text-danger"><small><del>Rp. 99.999</del></small></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn bg-kedua color-utama fs-5 col-10">Pesan</button>
                        <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2 col-md-6 col-lg-4">
            <div class="card p-2">
                <div class="p-0">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" style="height: 300px; object-fit:cover" class="col-sm-12 card-img-top rounded" alt="...">
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title fw-bold">Redvelvet</h4>
                        <h6 class="card-title fw-medium">Minuman</h6>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"><strong>Rp. 70.999</strong></p>
                        <p class="card-text text-danger"><small><del>Rp. 99.999</del></small></p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn bg-kedua color-utama fs-5 col-10" id='checkout'>Pesan</button>
                        <button class="btn color-utama w-100 d-flex justify-content-center align-items-center" style="border-color: var(--warna-kedua)" data-bs-toggle="modal" data-bs-target="#productModal"><i class="fa-solid fa-magnifying-glass color-keempat"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="productImage" style="height: 400px; object-fit:cover" src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Product Image" class="rounded img-fluid  mb-3 w-100">
                <h5 class="modal-title mb-3" id="productModalLabel">Redvelvet</h5>
                <p id="productDescription" class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime, rem iste libero exercitationem natus eos minus fugit ipsum ullam iusto facilis suscipit dolore explicabo doloremque ipsa error numquam beatae deserunt dicta in recusandae qui.</p>
                <button class="btn bg-kedua color-utama w-100" id="addToCart">
                    <i class="fa-solid fa-cart-shopping color-utama me-2"></i> Keranjang
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    
    document.getElementById('searchButton').addEventListener('click', function() {
        let query = 'Redvelvet'; // Hardcoded for example, you can fetch this from an input field

        fetch(`/search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let product = data.product;
                    document.getElementById('productModalLabel').textContent = product.name;
                    document.getElementById('productImage').src = product.image_url;
                    document.getElementById('productDescription').textContent = product.description;
                    new bootstrap.Modal(document.getElementById('productModal')).show();
                } else {
                    alert(data.message);
                }
            });
    });
</script>
@endsection