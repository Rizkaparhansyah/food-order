<nav class="navbar navbar-expand-lg bg-utama mb-3">
    <div class="container-fluid justify-content-center">
    <a class="navbar-brand color-keempat fw-bold" href="/menu">BADAMI CAFE</a>
    </div>
    <div class=" btn position-absolute me-5 end-0 position-relative" id="cart" data-url="{{route('cart')}}">
        <i class="fa-solid fa-cart-shopping  color-keempat"></i>
    </div>
    <div class="align-items-center justify-content-center d-flex start-0 position-absolute">

        <div class=" btn"><a href="{{route('status.user')}}" class="isi navbar-brand color-keempat">{{$nama}} <b>{{ $kode }}</b></a></i></div>
        <div class=" btn" id="loginIcon"><a class="isi navbar-brand color-keempat">
            <i class="fa-solid fa-user-circle color-keempat"></i>
        </a></i>
    </div>
    </div>
    <div class=" btn position-absolute me-3 end-0" id="logoutButton"><i class="fa-solid fa-right-from-bracket color-keempat"></i></div>
</nav>
@push('script')
    
<script>
    $(document).ready(function(){
        const cartButton = $('#cart');
        
        $(document).on('click', '#loginIcon', function(e) {
            $('#loginUser').modal('show');
        })

        $('#logoutButton').on('click', function (event) {
            console.log('sss')
            event.preventDefault();
    
            $.ajax({
                url: '{{ route('logout.user') }}',
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                success: function (data) {
                    if (!data.authenticated) {
                        $('#logoutButton').attr('hidden', true)
                        alert('berhasil.');
                        window.location.href = '/'; // Redirect ke halaman yang diinginkan
                    } else {
                        alert('Logout failed.');
                    }
                }
            });
        });
        
        $('#cart').on('click', function (event) {
            // console.log('first', event)
            event.preventDefault();
            const url = $(this).data('url')
            cekAuthUser(url)
        });
    });
</script>
@endpush
