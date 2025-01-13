<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'jesus@gmail.com'],
            [
                'name' => 'Jesús Augusto Anglas Ayme',
                'image' => 'default-avatar.png',
                'password' => bcrypt('password'),
            ]
        );
    }
}
