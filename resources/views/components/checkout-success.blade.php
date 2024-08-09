@extends('welcome')

@section('title', 'Checkout Success')
@section('content')
    <section class=" container">
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                alert("Checkout berhasil");
                window.location.href = "{{ url('/') }}"; // Redirect ke halaman utama setelah alert
            });
        </script>
    </section>
@endsection
