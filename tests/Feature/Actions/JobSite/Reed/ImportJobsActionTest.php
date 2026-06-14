<?php

use App\Actions\JobSite\Reed\ImportJobsAction;
use App\Actions\Reed\Api\{SearchJobsAction, GetJobAction};
use App\Enums\UserEnum;
use App\Models\User;
use Mockery\MockInterface;

describe('Reed - ImportJobsAction tests', function () {
    it('imports jobs from Reed API', function () {
        // Arrange
        $user = User::find(UserEnum::MAIN->value);

        $job = mock(SearchJobsAction::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn([
                    'results' => [
                        [
                            'jobId' => 123456,
                            'jobTitle' => 'Software Engineer',
                            'employerName' => 'Tech Corp',
                        ],
                        [
                            'jobId' => 789012,
                            'jobTitle' => 'Senior Software Engineer',
                            'employerName' => 'Tech Corp',
                        ],
                    ],
                ]);
        });

        $this->app->bind(SearchJobsAction::class, fn () => $job);

        $job = mock(GetJobAction::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn([
                    'results' => [
                        [
                            'jobId' => 123456,
                            'jobTitle' => 'Software Engineer',
                            'employerName' => 'Tech Corp',
                        ],
                        [
                            'jobId' => 789012,
                            'jobTitle' => 'Senior Software Engineer',
                            'employerName' => 'Tech Corp',
                        ],
                    ],
                ]);
        });

        $this->app->bind(GetJobAction::class, fn () => $job);

        // Act
        $result = resolve(ImportJobsAction::class)->execute($user);

        // Assert
        expect($result)
            ->toBeNumeric()
            ->toBeGreaterThanOrEqual(0);
    });
});
