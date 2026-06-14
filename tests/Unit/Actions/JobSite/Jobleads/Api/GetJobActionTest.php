<?php

use App\Actions\JobSite\Jobleads\Api\GetJobAction;

describe('Jobleads - GetJobAction tests', function () {
    it('calls Jobleads API and returns job details', function () {
        // Arrange
        $jobId = 123456;
        $response = [
            'payload' => [
                'jobSummary' => 'Software Engineer',
                'benefits' => [
                    'Health insurance',
                    'Paid time off',
                ],
                'qualifications' => [
                    'Bachelor\'s degree in Computer Science or related field',
                    '3+ years of experience in software development',
                ],
                'responsibilities' => [
                    'Develop and maintain web applications',
                    'Collaborate with cross-functional teams',
                ],
                'skills' => [
                    'Proficiency in PHP, JavaScript, and SQL',
                    'Experience with Laravel and Vue.js',
                ],
            ],
        ];

        Http::fake(fn () => Http::response($response, 200, ['Headers']));

        // Act
        $result = resolve(GetJobAction::class)->execute($jobId);

        // Assert
        expect($result)->toBeArray()
            ->and($result['payload']['jobSummary'])->toEqual('Software Engineer')
            ->and($result['payload']['benefits'])->toEqual([
                'Health insurance',
                'Paid time off',
            ])
            ->and($result['payload']['qualifications'])->toEqual([
                'Bachelor\'s degree in Computer Science or related field',
                '3+ years of experience in software development',
            ])
            ->and($result['payload']['responsibilities'])->toEqual([
                'Develop and maintain web applications',
                'Collaborate with cross-functional teams',
            ])
            ->and($result['payload']['skills'])->toEqual([
                'Proficiency in PHP, JavaScript, and SQL',
                'Experience with Laravel and Vue.js',
            ]);
    });
});
