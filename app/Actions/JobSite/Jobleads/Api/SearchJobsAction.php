<?php

namespace App\Actions\JobSite\Jobleads\Api;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;

class SearchJobsAction
{
    public function execute(array $searchTerms)
    {
        $apiUrl = config('services.jobleads.base_url') . '/job-search/search';

        $headers = [
            'User-Agent' => config('services.jobleads.user_agent'),
            'Accept'     => 'application/json',
        ];

        $response = Http::withHeaders($headers)
                        ->post(
                            $apiUrl,
                            $this->getPayload($searchTerms)
                        );

        throw_unless(
            $response->successful(),
            ApiException::class,
            'API request failed: ' . $response->getBody()
        );

        return $response->json();
    }

    private function getPayload(array $searchTerms): array
    {
        return [
            'keywords'      => $searchTerms,
            'filters'       => [
                ['key' => 'location', 'value' => ['alpha2Country' => 'GB', 'names' => ['united kingdom']], 'operator' => 'eq'],
                ['key' => 'minSalary', 'value' => 0, 'operator' => 'gte'],
                ['key' => 'radius', 'value' => 50, 'operator' => 'eq'],
                ['key' => 'radiusUnit', 'value' => 'MILES', 'operator' => 'eq'],
            ],
            'limit'         => 100,
            'engineOptions' => ['engineType' => 'vdbSearch'],

        ];
    }
}
