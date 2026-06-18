<?php

use App\Actions\JobSite\Larajobs\Feed\GetJobsAction;
use willvincent\Feeds\Facades\FeedsFacade;

describe('Larajobs - GetJobsAction tests', function () {
    it('calls Larajobs API and returns job details', function () {
        // Arrange
        $feedData = fixtureAsJson('larajobs/feed', true);
        $feed = new class($feedData)
        {
            public function __construct(private $items = null) {}

            public function get_items()
            {
                return array_map(fn ($item) => (object) $item, $this->items);
            }
        };

        $feedData = fixtureAsJson('larajobs/feed', true);

        FeedsFacade::shouldReceive('make')
            ->once()
            ->andReturn($feed);

        // Act
        $result = resolve(GetJobsAction::class)->execute();

        // Assert
        expect($result)
            ->toBeArray()
            ->toHaveCount(2)
            ->and(function ($result) use ($feedData) {
                expect($result[0]->get_id)->toBe($feedData[0]['get_id'])
                    ->and($result[0]->get_title)->toBe($feedData[0]['get_title'])
                    ->and($result[0]->get_date)->toBe($feedData[0]['get_date'])
                    ->and($result[0]->data['child']['https://larajobs.com']['salary'][0]['data'])->toBe($feedData[0]['data']['child']['https://larajobs.com']['salary'][0]['data'])
                    ->and($result[0]->data['child']['https://larajobs.com']['company'][0]['data'])->toBe($feedData[0]['data']['child']['https://larajobs.com']['company'][0]['data'])
                    ->and($result[0]->data['child']['https://larajobs.com']['location'][0]['data'])->toBe($feedData[0]['data']['child']['https://larajobs.com']['location'][0]['data'])
                    ->and($result[1]->get_id)->toBe($feedData[1]['get_id'])
                    ->and($result[1]->get_title)->toBe($feedData[1]['get_title'])
                    ->and($result[1]->get_date)->toBe($feedData[1]['get_date'])
                    ->and($result[1]->data['child']['https://larajobs.com']['salary'][0]['data'])->toBe($feedData[1]['data']['child']['https://larajobs.com']['salary'][0]['data'])
                    ->and($result[1]->data['child']['https://larajobs.com']['company'][0]['data'])->toBe($feedData[1]['data']['child']['https://larajobs.com']['company'][0]['data'])
                    ->and($result[1]->data['child']['https://larajobs.com']['location'][0]['data'])->toBe($feedData[1]['data']['child']['https://larajobs.com']['location'][0]['data']);
            });
    });
});
