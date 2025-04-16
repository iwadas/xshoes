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
            'email' => 'admin@example.com',
            'password' => '123123'
        ]);
        $admin->roles()->attach(1);
        $admin->roles()->attach(2);

        $moderator = User::factory()->create([
            'name' => 'moderator',
            'email' => 'moderator@example.com',
            'password' => '123123'
        ]);
        $moderator->roles()->attach(2);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => '123123'
        ]);

        User::factory(20)->create();
    }
}
