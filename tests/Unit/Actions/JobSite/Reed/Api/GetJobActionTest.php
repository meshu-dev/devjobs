<?php

use App\Actions\JobSite\Reed\Api\GetJobAction;

describe('Reed - GetJobAction tests', function () {
    it('calls Reed API and returns job details', function () {
        // Arrange
        $response = fixtureAsJson('reed/job', true);
        $jobId = $response['jobId'];

        Http::fake(fn () => Http::response($response, 200, ['Headers']));

        // Act
        $result = resolve(GetJobAction::class)->execute($jobId);

        // Assert
        expect($result)->toBeArray()
            ->and($result['jobId'])->toEqual($jobId)
            ->and($result['jobTitle'])->toEqual($response['jobTitle'])
            ->and($result['employerName'])->toEqual($response['employerName']);
    });
});
