i<?php

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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('kategori_id'); // Mengganti kolom kategori menjadi kategori_id
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->integer('stok');
            $table->integer('harga');
            $table->integer('diskon');
            $table->timestamps();
            
            // Menambahkan foreign key constraint
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
