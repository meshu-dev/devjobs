<?php

namespace App\Actions\Job;

use App\Models\User;

class ImportAllUserJobsAction
{
    public function execute(): void
    {
        User::all()->each(
            fn (User $user) => resolve(ImportJobsAction::class)->execute($user) 
        );
    }
}
