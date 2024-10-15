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
        Schema::table('penerimaan_barang', function (Blueprint $table) {
            $table->unsignedBigInteger('pesanan_pembelian_id')->nullable();
    
            // Assuming pesanan_pembelian table has an 'id' primary key
            $table->foreign('pesanan_pembelian_id')->references('id')->on('pesanan_pembelian')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerimaan_barang', function (Blueprint $table) {
            $table->dropForeign(['pesanan_pembelian_id']);
            $table->dropColumn('pesanan_pembelian_id');
        });
    }
};
