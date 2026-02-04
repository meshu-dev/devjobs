<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => env('USER_NAME', 'Test user'),
                'email'    => env('USER_EMAIL', 'example@mail.com'),
                'password' => Hash::make(env('USER_PASSWORD', 'testtest')),
            ],
            [
                'name'     => 'Demo',
                'email'    => 'demo@example.com',
                'password' => Hash::make('demo'),
            ]
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }
    }
}
