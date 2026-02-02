<?php

namespace App\Actions\Reed\Api;

use Illuminate\Support\Facades\Http;

class SearchJobsAction
{
    public function execute(string $search): array
    {
        $apiUrl = config('services.reed.url') . '/search';
        $apiKey = config('services.reed.key');

        return Http::withBasicAuth($apiKey, '')
                    ->get($apiUrl, [
                        'keywords' => $search,
                        'minimumSalary' => config('services.reed.min_salary'),
                    ])
                    ->json();
    }
}
