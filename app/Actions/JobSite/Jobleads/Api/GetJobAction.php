<?php

namespace App\Actions\JobSite\Jobleads\Api;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;

class GetJobAction
{
    /**
     * @return array<string, mixed>
     */
    public function execute(string $jobId): array
    {
        $jobId  = str_replace('external-', 'e', $jobId);
        $apiUrl = config('services.jobleads.base_url') . '/api/v3/job/detailsForAppNew/en_US/' . $jobId;

        $headers = [
            'User-Agent' => config('services.jobleads.user_agent'),
            'Accept'     => 'application/json',
        ];

        $response = Http::withHeaders($headers)
                        ->get($apiUrl);

        throw_unless(
            $response->successful(),
            ApiException::class,
            'API request failed: ' . $response->body()
        );

        return $response->json();
    }
}
