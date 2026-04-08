<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSite extends Model
{
    protected $table = 'job_sites';

    protected $fillable = [
        'name',
        'url',
    ];
}
