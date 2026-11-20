<?php

use App\Actions\Job\FavouriteJobAction;
use App\Enums\JobEnum;
use App\Enums\UserEnum;
use App\Models\Job;

describe('Job - FavouriteJobAction tests', function () {
    beforeEach(function () {
        $this->job = Job::find(JobEnum::SOFTWARE_ENGINEER->value);
        $this->job->update(['favourited' => false]);
    });

    it("toggles the user's job", function () {
        resolve(FavouriteJobAction::class)->execute(UserEnum::MAIN->value, $this->job->id);

        expect($this->job->fresh()->favourited)->toBeTruthy();
    });

    it("leaves another user's job unchanged", function () {
        resolve(FavouriteJobAction::class)->execute(UserEnum::DEMO->value, $this->job->id);

        expect($this->job->fresh()->favourited)->toBeFalsy();
    });
});
