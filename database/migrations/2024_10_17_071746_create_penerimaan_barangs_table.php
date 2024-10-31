<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penerimaan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_brg')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('harga_satuan')->nullable();
            $table->integer('total_harga')->nullable();
            $table->string('tgl_penerimaan')->nullable();
            $table->string('nama_pemasok')->nullable();
            $table->integer('no_faktur')->nullable();
            $table->string('lok_penyimpanan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_barangs');
    }
};
