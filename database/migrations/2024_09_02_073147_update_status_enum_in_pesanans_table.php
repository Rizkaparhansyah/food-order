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
        Schema::table('pesanans', function (Blueprint $table) {
            // Mengubah enum pada kolom status
            $table->enum('status', ['proses', 'selesai', 'pending', 'cancel'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Kembalikan perubahan jika migrasi di-rollback
            $table->enum('status', ['proses', 'selesai', 'pending'])->change();
        });
    }
};