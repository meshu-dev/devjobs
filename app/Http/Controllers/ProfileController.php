<?php

namespace App\Http\Controllers;

use App\Enums\FlashTypeEnum;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\{Inertia, Response};

class ProfileController extends Controller
{
    public function view(): Response
    {
        $user = Auth::user();
        return Inertia::render('Profile', ['user' => new ProfileResource($user)]);
    }

    public function edit(ProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();

        Inertia::flash([
            'message' => 'Profile has been updated',
            'type'    => FlashTypeEnum::SUCCESS,
        ]);

        return to_route('profile.view');
    }
}
