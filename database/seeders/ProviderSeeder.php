<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('providers')->insert([
            [
                'name'    => 'Sin registro',
                'email'   => 'sin registro',
                'ruc'     => '00000000000',
                'address' => 'Sin registro',
                'phone'   => '00000000000',
            ]
        ]);
    }
}
