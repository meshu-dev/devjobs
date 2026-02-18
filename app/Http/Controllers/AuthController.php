<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Auth;
use Inertia\{Inertia, Response};

class AuthController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        if (Auth::check()) {
            return to_route('job.list');
        }
        return Inertia::render('Login');
    }

    public function userLogin(LoginRequest $request)
    {
        return resolve(LoginAction::class)->execute($request);
    }

    public function demoLogin(Request $request)
    {
        $request->merge([
            'email'    => config('users.demo.email'),
            'password' => config('users.demo.password'),
        ]);
        return resolve(LoginAction::class)->execute($request);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return to_route('login');
    }
}
