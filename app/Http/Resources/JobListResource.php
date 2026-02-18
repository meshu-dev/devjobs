<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'employer'  => $this->employer,
            'location'  => $this->location,
            'posted_at' => Carbon::createFromFormat('Y-m-d', $this->posted_at)->format('d/m/Y'),
        ];
    }
}
