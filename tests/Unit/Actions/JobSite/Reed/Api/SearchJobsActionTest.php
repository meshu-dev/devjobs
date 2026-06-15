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
        $result = resolve(SearchJobsAction::class)->execute($search, $minSalary);

        // Assert
        expect($result['results'])->toBeArray()
            ->and($result['results'][0]['jobId'])->toEqual(123456)
            ->and($result['results'][0]['jobTitle'])->toEqual('Software Engineer')
            ->and($result['results'][0]['employerName'])->toEqual('Tech Corp')
            ->and($result['results'][1]['jobId'])->toEqual(789012)
            ->and($result['results'][1]['jobTitle'])->toEqual('Senior Software Engineer')
            ->and($result['results'][1]['employerName'])->toEqual('Tech Corp');
    });
});
