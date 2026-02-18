<?php

namespace App\Actions\Auth;

use App\Enums\FlashTypeEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginAction
{
    public function execute(Request $request): RedirectResponse
    {
        if (Auth::attempt($request->all())) {
            $request->session()->regenerate();
            return to_route('job.list');
        }

        return Inertia::flash([
            'message' => 'An error occurred logging into the user account',
            'type'    => FlashTypeEnum::ERROR,
        ])->back();
    }
}
