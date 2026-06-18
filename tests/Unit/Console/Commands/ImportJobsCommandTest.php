<?php

use App\Actions\Job\ImportAllUserJobsAction;
use Mockery\MockInterface;

describe('ImportJobsCommand tests', function () {
    it('runs import jobs command sucessfully', function () {
        // Assert
        $actionMock = mock(ImportAllUserJobsAction::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->once();
        });

        $this->app->bind(ImportAllUserJobsAction::class, fn () => $actionMock);

        // Act
        $this->artisan('app:import-jobs')->assertSuccessful();
    });
});
