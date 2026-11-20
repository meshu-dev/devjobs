<?php

use App\View\JobDates;
use Illuminate\Support\Carbon;

describe('JobDates tests', function () {
    beforeEach(function () {
        Carbon::setTestNow('2026-11-20 10:00:00');
    });

    afterEach(function () {
        Carbon::setTestNow();
    });

    it('names recent days', function (string $date, string $expected) {
        expect(JobDates::day($date))->toBe($expected);
    })->with([
        'today' => ['2026-11-20', 'Today'],
        'yesterday' => ['2026-11-19', 'Yesterday'],
        'this year' => ['2026-11-17', 'Tuesday 17 November'],
        'last year' => ['2025-11-17', 'Monday 17 November 2025'],
    ]);

    it('says when the next import runs', function (string $now, string $expected) {
        config(['jobs.import_time' => '15:00']);
        Carbon::setTestNow($now);

        expect(JobDates::nextImport())->toBe($expected);
    })->with([
        'before the import' => ['2026-11-20 10:00:00', 'today at 15:00'],
        'after the import' => ['2026-11-20 16:00:00', 'tomorrow at 15:00'],
    ]);
});
