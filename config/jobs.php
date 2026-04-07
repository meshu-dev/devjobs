<?php

use App\Enums\JobSiteEnum;

return [
    'descriptions' => [
        JobSiteEnum::LARAJOBS->value => 'Description unavailable from imported job.<br /><br />Click the "View Original" button to view full job description.',
    ],
    'pagination' => [
        'page_limit' => env('JOBS_PAGINATION_PAGE_LIMIT', 10),
    ],
];
