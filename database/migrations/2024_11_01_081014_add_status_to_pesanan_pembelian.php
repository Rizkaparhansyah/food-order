database\migrations\2024_10_15_023718_add_status_to_pesanan_pembelian.php

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
        Schema::table('pesanan_pembelian', function (Blueprint $table) {
            // Menambahkan kolom status
            $table->string('status')->default('diproses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan_pembelian', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};