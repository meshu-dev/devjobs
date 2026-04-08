<?php

namespace App\Actions\JobSite\Larajobs\Feed;

use willvincent\Feeds\Facades\FeedsFacade;

class GetJobsAction
{
    public function execute(): array
    {
        $url  = config('services.larajobs.url');

        $feed = FeedsFacade::make($url);
        $jobs = $feed->get_items();

        return $jobs;
    }
}
