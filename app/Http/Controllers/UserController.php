<?php

namespace App\Http\Controllers;

use Inertia\{Inertia, Response};

class UserController extends Controller
{
    public function profile(): Response
    {
        return Inertia::render('Profile', ['jobs' => null]);
    }
}
