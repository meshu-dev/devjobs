<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'employer'    => $this->employer,
            'location'    => $this->location,
            'min_salary'  => Number::currency($this->min_salary),
            'max_salary'  => Number::currency($this->max_salary),
            'posted_at'   => Carbon::createFromFormat('Y-m-d', $this->posted_at)->format('d/m/Y'),
        ];
    }
}
