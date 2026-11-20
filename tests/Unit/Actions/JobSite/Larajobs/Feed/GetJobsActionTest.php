<?php

use App\Actions\JobSite\Larajobs\Feed\GetJobsAction;
use Mockery\MockInterface;
use SimplePie\SimplePie;

describe('Larajobs - GetJobsAction tests', function () {
    it('calls Larajobs API and returns job details', function () {
        // Arrange
        $feedData = fixtureAsJson('larajobs/feed', true);
        $items = array_map(fn ($item) => (object) $item, $feedData);

        $feedMock = mock(SimplePie::class, function (MockInterface $mock) use ($items) {
            $mock->shouldReceive('set_feed_url')->once()->with(config('services.larajobs.url'));
            $mock->shouldReceive('set_cache')->once();
            $mock->shouldReceive('init')->once()->andReturn(true);
            $mock->shouldReceive('get_items')->once()->andReturn($items);
        });

        $this->app->bind(SimplePie::class, fn () => $feedMock);

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
