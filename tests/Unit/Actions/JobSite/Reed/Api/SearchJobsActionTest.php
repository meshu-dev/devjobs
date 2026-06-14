<?php

use App\Actions\JobSite\Reed\Api\SearchJobsAction;

describe('Reed - SearchJobsAction tests', function () {
    it('calls Reed API and returns job details', function () {
        // Arrange
        $search = 'Software Engineer';
        $minSalary = 50000;

        $response = fixtureAsJson('reed/search', true);

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
