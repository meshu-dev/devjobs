<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'user_id',
        'text',
        'context'
    ];

    protected $casts = [
        'context' => 'array',
    ];
}
