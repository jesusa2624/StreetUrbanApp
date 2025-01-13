<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'name' => 'Sin Datos',
            'dni' => '00000000',
            'ruc' => '00000000',
            'address' => 'Sin Dirección',
            'phone' => '000000000',
            'email' => 'Sin Datos',
        ]);
    }
}
