<?php

namespace App\Http\Controllers;

use App\Actions\Job\GetJobsAction;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Inertia\{Inertia, Response};

class UserController extends Controller
{
    public function profile(): Response
    {
        return Inertia::render('Profile', ['jobs' => null]);
    }
}
