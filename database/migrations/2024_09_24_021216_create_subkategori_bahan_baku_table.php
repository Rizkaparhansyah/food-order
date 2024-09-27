<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubkategoriBahanBakuTable extends Migration
{
    public function up()
    {
        Schema::create('subkategori_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_bahan_baku_id')->constrained('jenis_bahan_baku')->onDelete('cascade'); 
            $table->string('nama_subkategori'); // Subkategori (misal: Daging Ayam, Daging Sapi)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subkategori_bahan_baku');
    }
}
