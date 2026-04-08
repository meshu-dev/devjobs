<?php

namespace App\Actions\JobSite\Reed\Api;

use Illuminate\Support\Facades\Http;

class SearchJobsAction
{
    public function execute(string $search, int $minSalary, int $offset = 0): array
    {
        $apiUrl = config('services.reed.url') . '/search';
        $apiKey = config('services.reed.key');

        return Http::withBasicAuth($apiKey, '')
                    ->get($apiUrl, [
                        'keywords' => $search,
                        'minimumSalary' => $minSalary,
                        'resultsToTake' => config('services.reed.row_limit'),
                        'resultsToSkip' => $offset,
                    ])
                    ->json();
    }
}
