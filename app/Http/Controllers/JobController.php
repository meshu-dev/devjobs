<?php

namespace App\Http\Controllers;

use App\Actions\Job\GetJobsAction;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Inertia\{Inertia, Response};

class JobController extends Controller
{
    public function list(): Response
    {
        $jobPaginate = resolve(GetJobsAction::class)->execute();
        return Inertia::render('Home', ['jobs' => $jobPaginate]);
    }

    public function view(Job $job): Response
    {
        return Inertia::render('View', ['job' => new JobResource($job)]);
    }

    public function favourites(): Response
    {
        $jobPaginate = resolve(GetJobsAction::class)->execute();
        return Inertia::render('Favourites', ['jobs' => $jobPaginate]);
    }
}
