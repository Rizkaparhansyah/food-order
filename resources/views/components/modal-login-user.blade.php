<!-- Modal -->
<div class="modal fade" id="loginUser" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center">LOGIN</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="nama">Nama</label>
                <input type="text" class="mb-3 form-control" name="name" id="nama" placeholder="Masukan nama anda!">
                <input type="text" class="mb-3 form-control" name="kode" id="kode" placeholder="Masukan kode anda!">
                <button class="btn bg-kedua color-utama w-100" id="userSave">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            $('#userSave').on('click', function (event) {
                    const nama = $('#nama').val();
                    const kode = $('#kode').val();
                    event.preventDefault();
                    $.ajax({
                        url: '{{ route('user.login') }}',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        data: JSON.stringify({ name: nama, kode: kode, }),
                        success: function (data) {
                            console.log('data', data)
                            if (data.authenticated) {
                                $('#authModal').modal('hide');
                                window.location.href = '{{ route('cart') }}';
                            } else {
                                alert('Failed to login');
                            }
                        },
                        errors: function (data) {
                            alert('Gagal login!')
                        }
                    });
                })

        });
    </script>

    </script>    
@endpush