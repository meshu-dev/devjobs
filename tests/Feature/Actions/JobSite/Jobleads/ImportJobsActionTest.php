<?php

use App\Actions\JobSite\Jobleads\ImportJobsAction;
use App\Actions\JobSite\Jobleads\Api\SearchJobsAction;
use App\Actions\JobSite\Jobleads\Api\GetJobAction;
use App\Enums\UserEnum;
use App\Models\User;
use SimplePie\Item;
use SimplePie\SimplePie;
use Mockery\MockInterface;

describe('Jobleads - ImportJobsAction tests', function () {
    it('imports jobs from Jobleads API', function () {
        // Arrange
        Http::fake();

        $user = User::find(UserEnum::MAIN->value);
        $jobs = fixtureAsJson('jobleads/search');

        $searchJobsMock = mock(SearchJobsAction::class, function (MockInterface $mock) use ($jobs, $user) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($user->profile->search_terms)
                ->andReturn($jobs);
        });

        $this->app->bind(SearchJobsAction::class, fn () => $searchJobsMock);

        $getJobMock = mock(GetJobAction::class, function (MockInterface $mock) use ($jobs) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($jobs['jobResults'][0]['id'])
                ->andReturn($jobs['jobResults'][0]);

            $mock->shouldReceive('execute')
                ->once()
                ->with($jobs['jobResults'][1]['id'])
                ->andReturn($jobs['jobResults'][1]);
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
