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
                'id' => JobSiteEnum::REED->value,
                'name' => JobSiteEnum::REED->name(),
                'url' => JobSiteEnum::REED->url(),
            ],
            [
                'id' => JobSiteEnum::LARAJOBS->value,
                'name' => JobSiteEnum::LARAJOBS->name(),
                'url' => JobSiteEnum::LARAJOBS->url(),
            ],
            [
                'id' => JobSiteEnum::JOBLEADS->value,
                'name' => JobSiteEnum::JOBLEADS->name(),
                'url' => JobSiteEnum::JOBLEADS->url(),
            ],
        ]);
    }
}
