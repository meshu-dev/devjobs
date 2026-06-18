<?php

namespace App\Actions\JobSite\Reed\Api;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;

class GetJobAction
{
    /**
     * @return array<string, mixed>
     */
    public function execute(int $id): array
    {
        $apiUrl = config('services.reed.url')."/jobs/$id";
        $apiKey = config('services.reed.key');

        $response = Http::withBasicAuth($apiKey, '')
            ->get($apiUrl);

        throw_unless(
            $response->successful(),
            ApiException::class,
            'API request failed: '.$response->body()
        );

        return $response->json();
    }
}
