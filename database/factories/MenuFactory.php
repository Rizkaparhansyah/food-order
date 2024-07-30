<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->words(2, true), // Menggunakan tiga kata sebagai nama produk
            'kategori_id' => $this->faker->numberBetween(1, 10),
            // 'kategori' => $this->faker->randomElement(['Elektronik', 'Pakaian', 'Makanan', 'Peralatan Rumah Tangga']),
            'deskripsi' => $this->faker->sentence(),
            'foto' => $this->faker->imageUrl(640, 480, 'products', true),
            'stok' => $this->faker->numberBetween(1, 100),
            'diskon' => $this->faker->numberBetween(0, 50), // Persentase diskon antara 0% dan 50%
            'harga' => $this->faker->numberBetween(30000, 100000), // harga
        ];
    }
}
