<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStokToBahanbakuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bahanbaku', function (Blueprint $table) {
            $table->integer('stok')->default(0)->after('khusus'); // Menambahkan kolom stok
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bahanbaku', function (Blueprint $table) {
            $table->dropColumn('stok');
        });
    }
}
