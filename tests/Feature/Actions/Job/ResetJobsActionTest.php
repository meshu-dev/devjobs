<?php

use App\Actions\Job\ResetJobsAction;
use App\Enums\JobSiteEnum;
use App\Models\{User, UserProfile, Job};
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

describe('ResetJobsAction tests', function () {
    it('asserts that true is true', function () {
        // Arrange
        $user       = User::factory()->create();
        $userProfle = UserProfile::factory()->create(['user_id' => $user->id]);

        $user->profile = $userProfle;

        Job::factory()
            ->count(3)
            ->state(new Sequence(
                ['job_site_id' => JobSiteEnum::REED->value],
                ['job_site_id' => JobSiteEnum::LARAJOBS->value],
                ['job_site_id' => JobSiteEnum::JOBLEADS->value],
            ))
            ->create(['user_id' => $user->id]);

        // Act
        resolve(ResetJobsAction::class)->execute($user);

        // Assert
        assertDatabaseMissing('jobs', ['user_id' => $user->id]);
        assertDatabaseHas('user_profiles', ['user_id' => $user->id, 'reset_jobs' => false]);
    });
});
