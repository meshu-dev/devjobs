<?php

namespace App\Http\Controllers;

use App\Actions\Job\FavouriteJobAction;
use App\Actions\Job\GetJobsAction;
use App\Enums\FlashTypeEnum;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Inertia\{Inertia, Response};

class JobController extends Controller
{
    public function list(): Response
    {
        $jobPaginate = resolve(GetJobsAction::class)->execute();
        return Inertia::render('Home', ['jobs' => $jobPaginate]);
    }

    public function favouritesList(): Response
    {
        $jobPaginate = resolve(GetJobsAction::class)->execute(true);
        return Inertia::render('Favourites', ['jobs' => $jobPaginate]);
    }

    public function favourite(int $job): RedirectResponse
    {
        resolve(FavouriteJobAction::class)->execute($job);

        return Inertia::flash([
            'message' => 'Job has been updated',
            'type'    => FlashTypeEnum::SUCCESS,
        ])->back();
    }

    public function view(Job $job): Response
    {
        return Inertia::render('View', ['job' => new JobResource($job)]);
    }
}
