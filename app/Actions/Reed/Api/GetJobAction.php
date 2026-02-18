<?php

namespace App\Actions\Reed\Api;

use Illuminate\Support\Facades\Http;

class GetJobAction
{
    public function execute(int $id)
    {
        $apiUrl = config('services.reed.url') . "/jobs/$id";
        $apiKey = config('services.reed.key');

        return Http::withBasicAuth($apiKey, '')
                    ->get($apiUrl)
                    ->json();
    }
}
