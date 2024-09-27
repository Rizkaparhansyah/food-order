<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaanBahanBakuTable extends Migration
{
    public function up()
    {
        Schema::create('penggunaan_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penggunaan'); // Misal: Bahan Utama, Bahan Pendukung
            $table->boolean('khusus')->default(false); // Untuk menandai apakah bahan baku ini digunakan untuk acara khusus
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penggunaan_bahan_baku');
    }
}
