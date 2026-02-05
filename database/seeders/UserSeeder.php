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
                'name'     => config('users.main.name'),
                'email'    => config('users.main.email'),
                'password' => Hash::make(config('users.main.password')),
            ],
            [
                'name'     => config('users.demo.name'),
                'email'    => config('users.demo.email'),
                'password' => Hash::make(config('users.demo.password')),
            ]
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }
    }
}
