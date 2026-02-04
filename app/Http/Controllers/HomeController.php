<?php

namespace App\Http\Controllers;

use App\Actions\Job\GetJobsAction;
use App\Http\Resources\JobResource;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        /*
        $jobs = resolve(GetJobsAction::class)->execute();

        return Inertia::render('Home', ['jobs' => JobResource::collection($jobs)]); */

        return Inertia::render('Secret');
    }
}
