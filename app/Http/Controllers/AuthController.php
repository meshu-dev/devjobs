<?php

namespace App\Http\Controllers;

use App\Enums\FlashTypeEnum;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('Login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->all())) {
            $request->session()->regenerate();

            return to_route('job.index');
        }

        return Inertia::flash([
            'message' => 'An error occurred logging into the user account',
            'type'    => FlashTypeEnum::ERROR,
        ])->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return to_route('login');
    }
}
