<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;

    protected $table = 'job_roles';

    protected $fillable = [
        'user_id',
        'job_site_id',
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

    /**
     * @return BelongsTo<JobSite, $this>
     */
    public function jobSite(): BelongsTo
    {
        return $this->belongsTo(JobSite::class);
    }
}
