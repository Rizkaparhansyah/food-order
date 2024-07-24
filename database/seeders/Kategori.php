<?php

namespace Database\Seeders;

use App\Models\Kategori as KategoriModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Kategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriModel::factory()->count(10)->create();
    }
}
