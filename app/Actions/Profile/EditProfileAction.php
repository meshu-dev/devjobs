<?php

namespace App\Actions\Profile;

use Illuminate\Support\Facades\Auth;

class EditProfileAction
{
    public function execute(array $params)
    {
        $user    = Auth::user();
        $profile = $user->profile;
        
        $user->name          = $params['name'];
        $profile->min_salary = $params['min_salary'];
        $profile->max_salary = $params['max_salary'];

        $user->save();
        $profile->save();

        if ($profile->wasChanged()) {
            $profile->reset_jobs = true;
            $profile->save();
        } 
    }
}
