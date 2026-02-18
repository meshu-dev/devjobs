<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user' => [
                    'name'     => config('users.main.name'),
                    'email'    => config('users.main.email'),
                    'password' => Hash::make(config('users.main.password')),
                ],
                'profile' => [
                    'min_salary' => config('users.main.min_salary'),
                    'max_salary' => config('users.main.max_salary'),
                ],
            ],
            [
                'user' => [
                    'name'     => config('users.demo.name'),
                    'email'    => config('users.demo.email'),
                    'password' => Hash::make(config('users.demo.password')),
                ],
                'profile' => [
                    'min_salary' => config('users.demo.min_salary'),
                    'max_salary' => config('users.demo.max_salary'),
                ],
            ]
        ];

        foreach ($users as $user) {
            $userModel = User::factory()->create($user['user']);
            $user['profile']['user_id'] = $userModel->id;

            UserProfile::factory()->create($user['profile']);
        }
    }
}
