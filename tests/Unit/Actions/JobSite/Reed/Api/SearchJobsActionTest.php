<?php

use App\Actions\JobSite\Reed\Api\SearchJobsAction;

describe('Reed - SearchJobsAction tests', function () {
    it('calls Reed API and returns job details', function () {
        // Arrange
        $search = 'Software Engineer';
        $minSalary = 50000;

        $response = [
            [
                'jobId' => 123456,
                'jobTitle' => 'Software Engineer',
                'jobDescription' => 'We are looking for a skilled software engineer...',
                'employerName' => 'Tech Corp',
                'locationName' => 'Birmingham',
                'minimumSalary' => '50000',
                'maximumSalary' => '60000',
                'jobUrl' => 'https://www.reed.co.uk/jobs/software-engineer/123456',
                'applicationCount' => '78',
                'datePosted'   => '12/09/2025',
            ],
            [
                'jobId' => 789012,
                'jobTitle' => 'Senior Software Engineer',
                'jobDescription' => 'We are looking for a senior software engineer...',
                'employerName' => 'Tech Corp',
                'locationName' => 'London',
                'minimumSalary' => '70000',
                'maximumSalary' => '80000',
                'jobUrl' => 'https://www.reed.co.uk/jobs/senior-software-engineer/789012',
                'applicationCount' => '45',
                'datePosted'   => '15/09/2025',
            ]
        ];

        Http::fake(fn () => Http::response($response, 200, ['Headers']));

        // Act
        $results = resolve(SearchJobsAction::class)->execute($search, $minSalary);

        // Assert
        expect($results)->toBeArray()
            ->and($results[0]['jobId'])->toEqual(123456)
            ->and($results[0]['jobTitle'])->toEqual('Software Engineer')
            ->and($results[0]['employerName'])->toEqual('Tech Corp')
            ->and($results[1]['jobId'])->toEqual(789012)
            ->and($results[1]['jobTitle'])->toEqual('Senior Software Engineer')
            ->and($results[1]['employerName'])->toEqual('Tech Corp');
    });
});
