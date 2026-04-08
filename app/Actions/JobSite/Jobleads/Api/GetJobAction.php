<?php

namespace App\Actions\JobSite\Jobleads\Api;

use Illuminate\Support\Facades\Http;

class GetJobAction
{
    public function execute(string $jobId)
    {
        $jobId  = str_replace('external-', 'e', $jobId);
        $apiUrl = config('services.jobleads.base_url') . '/api/v3/job/detailsForAppNew/en_US/' . $jobId;

        $headers = [
            'User-Agent' => config('services.jobleads.user_agent'),
            'Accept'     => 'application/json',
        ];

        return Http::withHeaders($headers)->get($apiUrl)->json();
    }
}
