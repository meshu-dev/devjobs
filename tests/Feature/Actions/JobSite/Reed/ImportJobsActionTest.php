<?php

use App\Actions\JobSite\Reed\Api\GetJobAction;
use App\Actions\JobSite\Reed\Api\SearchJobsAction;
use App\Actions\JobSite\Reed\ImportJobsAction;
use App\Enums\UserEnum;
use App\Models\User;
use Mockery\MockInterface;

describe('Reed - ImportJobsAction tests', function () {
    it('imports jobs from Reed API', function () {
        // Arrange
        Http::fake();

        $user = User::find(UserEnum::MAIN->value);
        $jobs = fixtureAsJson('reed/search');

        $searchJobsMock = mock(SearchJobsAction::class, function (MockInterface $mock) use ($jobs, $user) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($user->profile->search_terms[0], $user->profile?->min_salary)
                ->andReturn($jobs);

            $mock->shouldReceive('execute')
                ->once()
                ->with($user->profile->search_terms[1], $user->profile?->min_salary)
                ->andReturn($jobs);
        });

        $this->app->bind(SearchJobsAction::class, fn () => $searchJobsMock);

        $getJobMock = mock(GetJobAction::class, function (MockInterface $mock) use ($jobs) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($jobs['results'][0]['jobId'])
                ->andReturn($jobs['results'][0]);

            $mock->shouldReceive('execute')
                ->once()
                ->with($jobs['results'][1]['jobId'])
                ->andReturn($jobs['results'][1]);
        });

        $this->app->bind(GetJobAction::class, fn () => $getJobMock);

        // Act
        $result = resolve(ImportJobsAction::class)->execute($user);

        // Assert
        expect($result)
            ->toBeNumeric()
            ->toBeGreaterThanOrEqual(0);
    });
});
