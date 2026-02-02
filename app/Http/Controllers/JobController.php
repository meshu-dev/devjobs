<?php

namespace App\Http\Controllers;

use App\Actions\Job\GetJobsAction;
use App\Actions\Reed\Api\GetJobAction;
use App\Http\Resources\JobListResource;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Inertia\Inertia;
use Inertia\Response;

class JobController extends Controller
{
    public function index(): Response
    {
        $jobs = resolve(GetJobsAction::class)->execute();

    //dd(JobListResource::collection($jobs));

        return Inertia::render('Home', ['jobs' => JobListResource::collection($jobs)]);
    }

    public function view(Job $job): Response
    {
        return Inertia::render('View', ['job' => new JobResource($job)]);
    }
}
