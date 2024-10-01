@extends('admin.layouts.app')

<style>
    .centered-button {
        text-align: center;
    }
</style>

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Plot Meja</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="pesananTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor Meja</th>
                                <th>Status</th>
                                <th>Kode Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th class="align-middle text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mejas as $meja)
                                <tr>
                                    <td>{{ $meja->nomor_meja }}</td>
                                    <td><?php if ($meja->status == 'terisi') {
                                        echo "<span class='badge badge-pill badge-primary'>Terisi</span>";
                                    } else {
                                        echo "<span class='badge badge-pill badge-secondary'>Kosong</span>";
                                    }
                                    ?>
                                    </td>
                                    <td>{{ $meja->kode ?? 'N/A' }}</td>
                                    <td>{{ $meja->nama ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <?php if($meja->status == 'terisi') {?>
                                        <form action="{{ route('meja.update', $meja->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger">Kosongkan</button>
                                        </form>
                                        <?php } else { echo "-"; }?>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection