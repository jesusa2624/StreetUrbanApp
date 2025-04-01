<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sizes')->insert([
            ['name' => 'XS'],
            ['name' => 'S'],
            ['name' => 'M'],
            ['name' => 'L'],
            ['name' => 'XL'],
            ['name' => 'XXL'],
            ['name' => '36'],
            ['name' => '37'],
            ['name' => '38'],
            ['name' => '39'],
            ['name' => '40'],
            ['name' => '41'],
            ['name' => '42'],
            ['name' => '43'],
            ['name' => '44'],
        ]);
    }
}
