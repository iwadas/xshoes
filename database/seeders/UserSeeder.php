<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '123123'
        ]);
        $admin->roles()->attach(1);
        $admin->roles()->attach(2);

        $moderator = User::factory()->create([
            'name' => 'moderator',
            'email' => 'moderator@gmail.com',
            'password' => '123123'
        ]);
        $moderator->roles()->attach(2);

        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => '123123'
        ]);
    }
}
