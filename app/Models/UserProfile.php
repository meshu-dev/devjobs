<?php

namespace App\Models;

use Database\Factories\UserProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /** @use HasFactory<UserProfileFactory> */
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'search_terms',
        'min_salary',
        'max_salary',
        'reset_jobs',
    ];

    protected $casts = [
        'search_terms' => 'array',
    ];
}
