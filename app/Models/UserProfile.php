<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'search_terms',
        'min_salary',
        'max_salary',
    ];

    protected $casts = [
        'search_terms' => 'array',
    ];
}
