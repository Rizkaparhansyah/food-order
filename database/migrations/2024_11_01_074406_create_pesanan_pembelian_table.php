<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananPembelianTable extends Migration
{
    public function up()
    {
        Schema::create('pesanan_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemasok');
            $table->date('tanggal_pesanan');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 8, 2);
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan_pembelian');
    }
}