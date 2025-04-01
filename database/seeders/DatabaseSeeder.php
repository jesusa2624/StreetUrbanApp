<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ClientSeeder::class,
            UsersTableSeeder::class,
            CategorySeeder::class,
            SizeSeeder::class,
            ProviderSeeder::class,
        ]);
    }
}
