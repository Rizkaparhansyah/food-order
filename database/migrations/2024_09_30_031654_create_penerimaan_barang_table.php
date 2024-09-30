<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanBarangTable extends Migration
{
    public function up()
    {
        Schema::create('penerimaan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 8, 2);
            $table->decimal('total_harga', 10, 2);
            $table->date('tanggal_penerimaan');
            $table->string('nama_pemasok');
            $table->string('nomor_faktur');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerimaan_barang');
    }
}
