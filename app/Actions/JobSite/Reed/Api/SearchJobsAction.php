<?php

namespace App\Actions\JobSite\Reed\Api;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;

class SearchJobsAction
{
    /**
     * @return array<string, mixed>
     */
    public function execute(string $search, int $minSalary, int $offset = 0): array
    {
        $apiUrl = config('services.reed.url').'/search';
        $apiKey = config('services.reed.key');

        $response = Http::withBasicAuth($apiKey, '')
            ->get($apiUrl, [
                'keywords' => $search,
                'minimumSalary' => $minSalary,
                'resultsToTake' => config('services.reed.row_limit'),
                'resultsToSkip' => $offset,
            ]);

        throw_unless(
            $response->successful(),
            ApiException::class,
            'API request failed: '.$response->body()
        );

        return $response->json();
    }
}
