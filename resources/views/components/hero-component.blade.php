@extends('welcome')

@section('title', 'Badami')

@section('content')
<div class="imag  justify-content-center d-flex" style="height: 90vh; background-image: url('https://images.unsplash.com/photo-1542372147193-a7aca54189cd?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; background-repeat: no-repeat; ">
    <!-- Konten lainnya -->
    <div class="jumbotron text-center d-flex align-items-center justify-content-center" style="height: 90vh; position: absolute; z-index: 1;">
        <div class="color-utama">
            <h1 class="display-4">Welcome to Badami</h1>
            <p class="lead"> "As long as there was coffee in the world, how bad could things be?"</p>
            <hr class="my-4">
            <p>Your Choice</p>
            <a class="btn bg-keempat btn-lg color-utama" href="{{url('menu')}}" role="button">Pesan sekarang</a>
        </div>
    </div>
</div>
@endsection