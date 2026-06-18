<?php

namespace Database\Seeders;

use App\Enums\UserEnum;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user' => [
                    'id' => UserEnum::MAIN->value,
                    'name' => config('users.main.name'),
                    'email' => config('users.main.email'),
                    'password' => Hash::make(config('users.main.password')),
                ],
                'profile' => [
                    'search_terms' => ['php developer', 'laravel developer'],
                    'min_salary' => config('users.main.min_salary'),
                    'max_salary' => config('users.main.max_salary'),
                    'reset_jobs' => false,
                ],
            ],
            [
                'user' => [
                    'id' => UserEnum::DEMO->value,
                    'name' => config('users.demo.name'),
                    'email' => config('users.demo.email'),
                    'password' => Hash::make(config('users.demo.password')),
                ],
                'profile' => [
                    'search_terms' => ['php developer', 'laravel developer'],
                    'min_salary' => config('users.demo.min_salary'),
                    'max_salary' => config('users.demo.max_salary'),
                    'reset_jobs' => false,
                ],
            ],
        ];

        foreach ($users as $user) {
            $userModel = User::factory()->create($user['user']);
            $user['profile']['user_id'] = $userModel->id;

            UserProfile::factory()->create($user['profile']);
        }
    }
}
