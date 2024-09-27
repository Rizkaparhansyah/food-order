<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisBahanBakuTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis'); // Jenis bahan baku (misal: Daging, Sayuran)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_bahan_baku');
    }
}
