<?php

use App\Actions\JobSite\Larajobs\Feed\GetJobsAction;
use willvincent\Feeds\Facades\FeedsFacade;

describe('Larajobs - GetJobsAction tests', function () {
    it('calls Larajobs API and returns job details', function () {
        // Arrange
        $feed = new class {
            public function get_items()
            {
                return [
                    (object) [
                        'get_id' => 'https://larajobs.com/jobs/12345',
                        'get_title' => 'Software Engineer',
                        'get_date' => '2023-06-01',
                        'data' => [
                            'child' => [
                                'https://larajobs.com' => [
                                    'salary' => [
                                        ['data' => '50000-60000'],
                                    ],
                                    'company' => [
                                        ['data' => 'Tech Corp'],
                                    ],
                                    'location' => [
                                        ['data' => 'London'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    (object) [
                        'get_id' => 'https://larajobs.com/jobs/67890',
                        'get_title' => 'Senior Developer',
                        'get_date' => '2023-06-02',
                        'data' => [
                            'child' => [
                                'https://larajobs.com' => [
                                    'salary' => [
                                        ['data' => '70000-80000'],
                                    ],
                                    'company' => [
                                        ['data' => 'Innovate Ltd'],
                                    ],
                                    'location' => [
                                        ['data' => 'Manchester'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ];
            }
        };

        FeedsFacade::shouldReceive('make')
            ->once()
            ->andReturn($feed);

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
