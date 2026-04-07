<?php

namespace Database\Seeders;

use App\Enums\JobSiteEnum;
use App\Models\JobSite;
use Illuminate\Database\Seeder;

class JobSiteSeeder extends Seeder
{
    public function run(): void
    {
        JobSite::insert([
            [
                'id'   => JobSiteEnum::REED->value,
                'name' => JobSiteEnum::REED->name(),
            ],
            [
                'id'   => JobSiteEnum::LARAJOBS->value,
                'name' => JobSiteEnum::LARAJOBS->name(),
            ]
        ]);
    }
}
