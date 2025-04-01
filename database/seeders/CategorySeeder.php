<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Camisas',
            'description' => 'Camisas formales y casuales para todas las edades y géneros.',
        ]);

        Category::create([
            'name' => 'Polos',
            'description' => 'Polos casuales y cómodos para hombres, mujeres y niños.',
        ]);

        Category::create([
            'name' => 'Pantalones',
            'description' => 'Pantalones de vestir, jeans y joggers para todos.',
        ]);

        Category::create([
            'name' => 'Shorts',
            'description' => 'Shorts deportivos y casuales para hombres, mujeres y niños.',
        ]);

        Category::create([
            'name' => 'Abrigos',
            'description' => 'Abrigos, poleras, chaquetas y cazadoras para todas las estaciones.',
        ]);

        Category::create([
            'name' => 'Ropa interior',
            'description' => 'Prendas íntimas cómodas para hombres, mujeres y niños.',
        ]);

        Category::create([
            'name' => 'Accesorios',
            'description' => 'Sombreros, bufandas, guantes y otros accesorios de moda.',
        ]);

        Category::create([
            'name' => 'Calzado',
            'description' => 'Zapatos, sandalias, botas y zapatillas para todas las edades.',
        ]);

        Category::create([
            'name' => 'Deportiva',
            'description' => 'Ropa y accesorios deportivos para actividades físicas.',
        ]);

        Category::create([
            'name' => 'Niños',
            'description' => 'Ropa y calzado diseñados especialmente para niños y niñas.',
        ]);
    }
}
