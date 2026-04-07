<?php

namespace App\Actions\Reed\Api;

use Illuminate\Support\Facades\Http;

class SearchJobsAction
{
    public function execute(string $search, int $offset = 0): array
    {
        $apiUrl = config('services.reed.url') . '/search';
        $apiKey = config('services.reed.key');

        return Http::withBasicAuth($apiKey, '')
                    ->get($apiUrl, [
                        'keywords' => $search,
                        'minimumSalary' => config('services.reed.min_salary'),
                        'resultsToTake' => config('services.reed.row_limit'),
                        'resultsToSkip' => $offset,
                    ])
                    ->json();
    }
}
