<?php

use App\Actions\JobSite\Larajobs\Feed\GetJobsAction;
use willvincent\Feeds\Facades\FeedsFacade;

describe('Larajobs - GetJobsAction tests', function () {
    it('calls Larajobs API and returns job details', function () {
        // Arrange
        $feed = new class {
            public function __construct(private $items = null)
            {
            }

            public function get_items()
            {
                return array_map(fn ($item) => (object) $item, $this->items);
            }
        };

        $feedData = fixtureAsJson('larajobs/feed', true);

        FeedsFacade::shouldReceive('make')
            ->once()
            ->andReturn($feed($feedData));

        // Act
        $result = resolve(GetJobsAction::class)->execute();

        // Assert
        expect($result)
            ->toBeArray()
            ->toHaveCount(2)
            ->and(function ($result) {
                expect($result[0]->get_id)->toBe('https://larajobs.com/jobs/12345')
                    ->and($result[0]->get_title)->toBe('Software Engineer')
                    ->and($result[0]->get_date)->toBe('2023-06-01')
                    ->and($result[0]->data['child']['https://larajobs.com']['salary'][0]['data'])->toBe('50000-60000')
                    ->and($result[0]->data['child']['https://larajobs.com']['company'][0]['data'])->toBe('Tech Corp')
                    ->and($result[0]->data['child']['https://larajobs.com']['location'][0]['data'])->toBe('London');
                expect($result[1]->get_id)->toBe('https://larajobs.com/jobs/67890')
                    ->and($result[1]->get_title)->toBe('Senior Developer')
                    ->and($result[1]->get_date)->toBe('2023-06-02')
                    ->and($result[1]->data['child']['https://larajobs.com']['salary'][0]['data'])->toBe('70000-80000')
                    ->and($result[1]->data['child']['https://larajobs.com']['company'][0]['data'])->toBe('Innovate Ltd')
                    ->and($result[1]->data['child']['https://larajobs.com']['location'][0]['data'])->toBe('Manchester');
            });
    });
});
