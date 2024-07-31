@extends('welcome')

@section('title', 'Cart')
@section('content')
  <section class=" container" >

          {{-- <div class="card mb-3 mt-3" style="width: 400px">
              <div class="row d-flex">
                <div class="d-flex align-items-center justify-content-center">
                  <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid m-1 rounded" alt="..." style="width: 130px; height: 130px; object-fit:cover">
                </div>
                <div class="col-md-6 ">
                  <div class="card-body  d-grid align-items-center justify-content-center">
                    <h5 class="card-title">Redvelvet</h5>
                    <div class="d-flex gap-2 flex-wrap">
                      <p class="card-text text-success"> <strong>Rp. 70.999</strong></p>
                      <p class="card-text  text-danger"> <small><del>Rp. 99.999</del></small></p></div>
                    <div class="card-text d-flex justify-content-center gap-4 align-items-center">
                      <i class="fa-solid fa-minus p-1 border border-1 rounded-circle"></i>
                      <div >2</div>
                      <i class="fa-solid fa-plus p-1 border border-1 rounded-circle"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 d-flex justify-content-center align-items-center ">
                  <i class="fa-solid fa-trash text-danger"></i>
                </div>
              </div>
          </div> --}}
    <div class="d-flex justify-content-center">
      <div style="width:500px">
          <div class="row ">
            <div class="col-12">
              <div class="card mb-3">
                <div class="row g-0 d-flex">
                  <div class="col-4 d-flex justify-content-start align-items-center ">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid m-1 rounded" alt="..." style="width: 150px; height: 150px; object-fit:cover" class="img-fluid rounded" alt="...">
                  </div>
                  <div class="col-6 ">
                    <div class="card-body">
                      <h5 class="card-title">Redvelvet</h5>
                      <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"> <strong>Rp. 70.999</strong></p>
                        <p class="card-text  text-danger"> <small><del>Rp. 99.999</del></small></p></div>
                      <div class="card-text d-flex justify-content-center gap-4 align-items-center">
                        <i class="fa-solid fa-minus p-1 border border-1 rounded-circle"></i>
                        <div >2</div>
                        <i class="fa-solid fa-plus p-1 border border-1 rounded-circle"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-2 d-flex justify-content-center align-items-center ">
                    <i class="fa-solid fa-trash text-danger"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card mb-3">
                <div class="row g-0 d-flex">
                  <div class="col-4 d-flex justify-content-start align-items-center ">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid m-1 rounded" alt="..." style="width: 150px; height: 150px; object-fit:cover" class="img-fluid rounded" alt="...">
                  </div>
                  <div class="col-6 ">
                    <div class="card-body">
                      <h5 class="card-title">Redvelvet</h5>
                      <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"> <strong>Rp. 70.999</strong></p>
                        <p class="card-text  text-danger"> <small><del>Rp. 99.999</del></small></p></div>
                      <div class="card-text d-flex justify-content-center gap-4 align-items-center">
                        <i class="fa-solid fa-minus p-1 border border-1 rounded-circle"></i>
                        <div >2</div>
                        <i class="fa-solid fa-plus p-1 border border-1 rounded-circle"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-2 d-flex justify-content-center align-items-center ">
                    <i class="fa-solid fa-trash text-danger"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card mb-3">
                <div class="row g-0 d-flex">
                  <div class="col-4 d-flex justify-content-start align-items-center ">
                    <img src="https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid m-1 rounded" alt="..." style="width: 150px; height: 150px; object-fit:cover" class="img-fluid rounded" alt="...">
                  </div>
                  <div class="col-6 ">
                    <div class="card-body">
                      <h5 class="card-title">Redvelvet</h5>
                      <div class="d-flex gap-2 flex-wrap">
                        <p class="card-text text-success"> <strong>Rp. 70.999</strong></p>
                        <p class="card-text  text-danger"> <small><del>Rp. 99.999</del></small></p></div>
                      <div class="card-text d-flex justify-content-center gap-4 align-items-center">
                        <i class="fa-solid fa-minus p-1 border border-1 rounded-circle"></i>
                        <div >2</div>
                        <i class="fa-solid fa-plus p-1 border border-1 rounded-circle"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-2 d-flex justify-content-center align-items-center ">
                    <i class="fa-solid fa-trash text-danger"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row ">
            <div class="d-flex justify-content-center align-items-center col-12 py-2 flex-column" >
              <div class="total d-flex justify-content-end w-100 fs-3 fw-bold text-end" >Rp 99.999</div>
              <div class="btn bg-kedua color-utama w-100  ">Checkout</div>
            </div>
          </div>
        </div>
    </div>
  </section>

@endsection 