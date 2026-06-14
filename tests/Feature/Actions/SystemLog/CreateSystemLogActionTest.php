<?php

use App\Actions\SystemLog\CreateSystemLogAction;
use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;

describe('CreateSystemLogAction tests', function () {
    it('asserts that true is true', function () {
        // Arrange
        $user = User::factory()->create();
        $message = 'Job importer ran successfully';

        // Act
        resolve(CreateSystemLogAction::class)->execute($user->id, $message, ['totalNewJobs' => 56]);

        // Assert
        assertDatabaseHas('system_logs', ['user_id' => $user->id, 'text' => $message]);
    });
});
