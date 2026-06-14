<?php

use App\Actions\JobSite\Jobleads\Api\SearchJobsAction;

describe('Jobleads - SearchJobsAction tests', function () {
    it('calls Jobleads API and returns job details', function () {
        // Arrange
        $response = fixtureAsJson('jobleads/search');

        Http::fake(fn () => Http::response($response, 200, ['Headers']));

        $searchTerms = ['Software Engineer', 'PHP', 'Laravel'];

        // Act
        $results = resolve(SearchJobsAction::class)->execute($searchTerms);

        // Assert
        expect($results)->toBeArray()
            ->toHaveKey('jobResults')
            ->and($results['jobResults'])->toBeArray()
            ->toHaveCount(2)
            ->and($results['jobResults'][0])->toBeArray()
            ->toHaveKeys(['id', 'jobTitle', 'companyName', 'minSalary', 'maxSalary', 'jobLink', 'alpha2Country', 'salaryCurrency', 'validFrom'])
            ->and($results['jobResults'][1])->toBeArray()
            ->toHaveKeys(['id', 'jobTitle', 'companyName', 'minSalary', 'maxSalary', 'jobLink', 'alpha2Country', 'salaryCurrency', 'validFrom']);
    });
});
