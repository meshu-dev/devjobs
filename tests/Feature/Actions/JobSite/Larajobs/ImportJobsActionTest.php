<?php

use App\Actions\JobSite\Larajobs\ImportJobsAction;
use App\Actions\JobSite\Larajobs\Feed\GetJobsAction;
use App\Enums\UserEnum;
use App\Models\User;
use SimplePie\Item;
use SimplePie\SimplePie;
use Mockery\MockInterface;

describe('Larajobs - ImportJobsAction tests', function () {
    it('imports jobs from Larajobs API', function () {
        // Arrange
        Http::fake();

        $user = User::find(UserEnum::MAIN->value);
        $jobs = fixtureAsJson('larajobs/feed');
        $list = [];

        foreach ($jobs as $job) {
            $list[] = new Item(
                new SimplePie(),
                [
                    'title' => $job['get_title'],
                    'id' => $job['get_id'],
                    'data' => $job['data'],
                ]
            );
        }

        $getJobsMock = mock(GetJobsAction::class, function (MockInterface $mock) use ($list) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn($list);
        });

        $this->app->bind(GetJobsAction::class, fn () => $getJobsMock);

        // Act
        $result = resolve(ImportJobsAction::class)->execute($user);

        // Assert
        expect($result)
            ->toBeNumeric()
            ->toBeGreaterThanOrEqual(0);
    })->skip();
});
