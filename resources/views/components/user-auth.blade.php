<!-- Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('auth.verify')}}" id="formUser" method="POST">
                    @csrf
                    <label for="table">Meja</label>
                    <select class="form-control" name="table" id="table">
                        <option value="">-- Pilih Meja --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                <label for="namaUser">Nama</label>
                <input type="text" class="mb-3 form-control" name="name" id="namaUser" placeholder="Masukan nama anda!">
                <button type="submit" class="btn bg-kedua color-utama w-100" id="logUser">
                    Simpan
                </button>
            </form>
            </div>
        </div>
    </div>
</div>
