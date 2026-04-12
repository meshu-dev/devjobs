<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'text',
        'context'
    ];

    protected $casts = [
        'context' => 'array',
    ];
}
