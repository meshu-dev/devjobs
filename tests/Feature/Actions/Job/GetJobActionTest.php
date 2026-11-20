<?php

use App\Actions\Job\GetJobAction;
use App\Enums\JobEnum;
use App\Enums\UserEnum;

describe('Job - GetJobAction tests', function () {
    it('gets a job belonging to the user', function () {
        $job = resolve(GetJobAction::class)->execute(UserEnum::MAIN->value, JobEnum::SOFTWARE_ENGINEER->value);

        expect($job?->id)->toBe(JobEnum::SOFTWARE_ENGINEER->value);
    });

    it("does not get another user's job", function () {
        $job = resolve(GetJobAction::class)->execute(UserEnum::DEMO->value, JobEnum::SOFTWARE_ENGINEER->value);

        expect($job)->toBeNull();
    });
});
