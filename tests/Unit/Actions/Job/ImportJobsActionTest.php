<?php

use App\Actions\Job\{ImportJobsAction, ResetJobsAction};
use App\Actions\JobSite\Reed\ImportJobsAction as ReedImportJobsAction;
use App\Actions\JobSite\Larajobs\ImportJobsAction as LarajobsImportJobsAction;
use App\Actions\JobSite\Jobleads\ImportJobsAction as JobleadsImportJobsAction;
use App\Actions\SystemLog\CreateSystemLogAction;
use App\Models\User;
use Mockery\MockInterface;

describe('ImportJobsAction tests', function () {
    it('imports jobs from all importers', function () {
        // Arrange
        $user = User::factory()->make(['id' => 1]);

        // Assert
        $job = mock(ResetJobsAction::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($user);
        });

        $this->app->bind(ResetJobsAction::class, fn () => $job);

        $importers = [
            ReedImportJobsAction::class,
            LarajobsImportJobsAction::class,
            JobleadsImportJobsAction::class,
        ];
        
        foreach ($importers as $importer) {
            $jobMock = mock($importer, function (MockInterface $mock) use ($user) {
                $mock->shouldReceive('execute')
                    ->once();
            });

            $this->app->bind($importer, fn () => $jobMock);

        }

        $job = mock(CreateSystemLogAction::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('execute')
                ->once();
        });

        $this->app->bind(CreateSystemLogAction::class, fn () => $job);

        // Act
        resolve(ImportJobsAction::class)->execute($user);
    });
});
