<?php

namespace App\Http\Controllers;

use App\Actions\Job\GetJobsAction;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\JobResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('Login');
    }

    public function login(LoginRequest $request)
    {
        dd($request);
        if (Auth::attempt($request->all())) {
            $request->session()->regenerate();

            return to_route('users.index');
        }

        $jobs = resolve(GetJobsAction::class)->execute();

        return Inertia::render('Home', ['jobs' => JobResource::collection($jobs)]);
    }
}
