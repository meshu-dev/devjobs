<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;

    protected $table = 'job_roles';

    protected $fillable = [
        'job_id',
        'title',
        'description',
        'employer',
        'location',
        'min_salary',
        'max_salary',
        'url',
        'params',
        'posted_at',
    ];

    protected function casts(): array
    {
        return [
            'params' => 'array',
        ];
    }
}
