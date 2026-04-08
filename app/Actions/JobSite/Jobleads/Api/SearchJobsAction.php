<?php

namespace App\Actions\JobSite\Jobleads\Api;

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

        return Http::withHeaders($headers)->post($apiUrl, $this->getPayload($searchTerms))->json();
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
