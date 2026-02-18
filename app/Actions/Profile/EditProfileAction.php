<?php

namespace App\Actions\Profile;

use Illuminate\Support\Facades\Auth;

class EditProfileAction
{
    public function execute(array $params)
    {
        $user             = Auth::user();
        $user->name       = $params['name'];
        $user->profile->min_salary = $params['min_salary'];
        $user->profile->max_salary = $params['max_salary'];

        $user->save();
        $user->profile->save();
    }
}
