<?php

use App\Actions\JobSite\Reed\Api\GetJobAction;

describe('Reed - GetJobAction tests', function () {
    it('calls Reed API and returns job details', function () {
        // Arrange
        $jobId = 123456;
        $response = [
            'jobId' => $jobId,
            'jobTitle' => 'Software Engineer',
            'jobDescription' => 'We are looking for a skilled software engineer...',
            'employerName' => 'Tech Corp',
            'locationName' => 'London',
            'minimumSalary' => '50000',
            'maximumSalary' => '60000',
            'jobUrl' => 'https://www.reed.co.uk/jobs/software-engineer/123456',
            'applicationCount' => '78',
            'datePosted'   => '12/09/2025',
        ];

        Http::fake(fn () => Http::response($response, 200, ['Headers']));

        // Act
        $result = resolve(GetJobAction::class)->execute($jobId);

        // Assert
        expect($result)->toBeArray()
            ->and($result['jobId'])->toEqual($jobId)
            ->and($result['jobTitle'])->toEqual('Software Engineer')
            ->and($result['employerName'])->toEqual('Tech Corp');
    });
});
