@extends('admin.layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Makanan</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button href="" id="addMenu" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                </div> 
                <div class="card-body">

                    <table id="menuTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Diskon</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
<div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menu</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="menu-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            
                            <div class="form-group">
                                <input type="hidden" name="id" id="idMenu">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Ex: Nasi Goreng">
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" name="kategori" class="form-control" id="kategori">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($data as $item)
                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" placeholder="Deskripsikan menu anda"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="hidden" id="idVal">
                                <label for="foto">Foto</label>
                                <div class="input-group mb-3">
                                    <input type="file" name="foto" class="form-control" id="foto">
                                    <label class="input-group-text" for="foto">Upload</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="harga">Rp</label>
                                    <input type="number"  name="harga"  class="form-control" id="harga">
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-6">
                                    <label for="stok">Stok</label>
                                    <input type="number" inputmode="numeric"  name="stok" class="form-control" id="stok">
                                </div>
                                <div class="form-group col-6">
                                    <label for="diskon">Diskon</label>
                                    <div class="input-group mb-3">
                                        <input type="number" inputmode="numeric"  name="diskon"  id="diskon" class="form-control" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="simpanMenu">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    
<script>
    $(document).ready( function () {
        $('#menuTable').DataTable(
            {
                scrollable: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('list.menu') }}',
                columns: [
                    { data: 'id', name: 'id', visible: false},
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama', name: 'nama' },
                    { data: 'kategori', name: 'kategori' },
                    { data: 'deskripsi', name: 'deskripsi' },
                    { data: 'foto', name: 'foto', orderable: false, searchable: false, 
                    render: function(data) {
                        return `<img src="{{asset('storage')}}/${data}" width="50" height="50">`;
                    }},
                    { data: 'harga', name: 'harga', render: function(data) {
                        return formatRupiah(data);
                    }},
                    { data: 'stok', name: 'stok' },
                    { data: 'diskon', name: 'diskon', render: function(data) {
                        return `<p>${data}%</p>`;
                    }},
                    { data: 'aksi', name: 'aksi' }
                ],
                order: [[0, 'desc']]
        });

        const alertSwal = (icon, title, message) => {
            Swal.fire({
                icon: icon,
                title: title,
                text: message,
                showConfirmButton: false,
                timer: 1500
            });
        };

        function formatRupiah(amount) {
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            });
            return formatter.format(amount);
        }

        $(document).on('hidden.bs.modal', function(event){
            $('#idMenu').val('');
            $('#nama').val('');
            $('#kategori').val('');
            $('#deskripsi').val('');
            $('#harga').val('');
            $('#stok').val('');
            $('#diskon').val('');
        })

        $('#menu-form').on('submit', function(e) {
                e.preventDefault();

                // Ambil seluruh data form
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('menu.tambah') }}',
                    type: 'POST',
                    _token: '{{ csrf_token() }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alertSwal('success', 'Berhasil', response.message);
                        $('#menu-form').trigger('reset');
                        $('#modalMenu').modal('hide');
                        $('#menuTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alertSwal('error', 'Gagal', 'Data gagal ditambahkan');
                    }
                });
            });
        
            $('#addMenu').on('click', function(){
            $('#modalMenu').modal('show');
        })

        $(document).on('click','.editMenu', function(){
           const data = $(this).data('data');
           $('#idMenu').val(data.id);
           $('#nama').val(data.nama);
           $('#kategori').val(data.kategori_id);
           $('#deskripsi').val(data.deskripsi);
           $('#harga').val(data.harga);
           $('#stok').val(data.stok);
           $('#diskon').val(data.diskon);

            $('#modalMenu').modal('show');
        })

        const deleteData = id => {
            $.ajax({
                url: '/admin/menu-hapus/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    alertSwal('success', 'Berhasil!', 'Data berhasil dihapus.');
                    $('#menuTable').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    alertSwal('error', 'Gagal!', 'Data gagal dihapus.');
                }
            });
        }
        
        window.konfirmasiHapus = id => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(id);
                }
            });
        }

        
    } );
</script>
@endpush