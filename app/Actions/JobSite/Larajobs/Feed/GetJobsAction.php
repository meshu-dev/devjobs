<?php

namespace App\Actions\JobSite\Larajobs\Feed;

use Illuminate\Support\Facades\Cache;
use SimplePie\Item;
use SimplePie\SimplePie;

class GetJobsAction
{
    public function __construct(private SimplePie $feed) {}

    /**
     * @return array<int, Item>
     */
    public function execute(): array
    {
        $this->feed->set_feed_url(config('services.larajobs.url'));
        $this->feed->set_cache(Cache::store());
        $this->feed->init();

        return $this->feed->get_items();
    }
}
