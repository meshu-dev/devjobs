<?php

namespace App\Models;

use App\Actions\Job\GetJobSalaryAction;
use Illuminate\Database\Eloquent\Casts\AsHtmlString;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;

    use HasUlids;

    protected $table = 'job_roles';

    protected $fillable = [
        'id',
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
        'favourited',
        'params',
        'posted_at',
    ];

    protected function casts(): array
    {
        return [
            'description' => AsHtmlString::class,
            'params' => 'array',
        ];
    }

    /**
     * Get the short version of the salary value
     *
     * @return Attribute<string|int, never>
     */
    protected function salaryShortened(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return resolve(GetJobSalaryAction::class)->execute(
                    $attributes['min_salary'],
                    $attributes['max_salary'],
                    true
                );
            }
        );
    }

    /**
     * Get min and max salary values combined into single string
     *
     * @return Attribute<string, never>
     */
    protected function salary(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return resolve(GetJobSalaryAction::class)->execute(
                    $attributes['min_salary'],
                    $attributes['max_salary']
                );
            }
        );
    }

    /**
     * @return BelongsTo<JobSite, $this>
     */
    public function jobSite(): BelongsTo
    {
        return $this->belongsTo(JobSite::class);
    }
}
