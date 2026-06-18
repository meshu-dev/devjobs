<?php

use App\Actions\Job\ImportAllUserJobsAction;
use App\Actions\Job\ImportJobsAction;
use App\Models\User;
use Mockery\MockInterface;

describe('ImportAllUserJobs tests', function () {
    it('runs the job import for all users', function () {
        // Assert
        $users = User::all();

        $actionMock = mock(ImportJobsAction::class, function (MockInterface $mock) use ($users) {
            $mock->shouldReceive('execute')->times($users->count());
        });

        $this->app->bind(ImportJobsAction::class, fn () => $actionMock);


        // Act
        resolve(ImportAllUserJobsAction::class)->execute();
    });
});
