<?php

use App\View\SalaryBand;

describe('SalaryBand tests', function () {
    beforeEach(function () {
        config(['users.min_salary_limit' => 20000, 'users.max_salary_limit' => 100000]);
    });

    it('places the job and target ranges on the profile salary scale', function () {
        $band = SalaryBand::make(40000, 60000, 30000, 50000);

        expect($band->jobStart)->toBe(25.0)
            ->and($band->jobWidth)->toBe(25.0)
            ->and($band->targetStart)->toBe(12.5)
            ->and($band->targetWidth)->toBe(25.0)
            ->and($band->fit)->toBe(SalaryBand::WITHIN)
            ->and($band->label)->toBe('£40K to £60K. Overlaps your target of £30K to £50K.');
    });

    it('describes jobs below and above the target', function (int $min, int $max, string $fit, string $word) {
        $band = SalaryBand::make($min, $max, 40000, 60000);

        expect($band->fit)->toBe($fit)
            ->and($band->label)->toContain($word.' your target');
    })->with([
        'below' => [25000, 35000, SalaryBand::BELOW, 'Below'],
        'above' => [70000, 90000, SalaryBand::ABOVE, 'Above'],
    ]);

    it('widens the scale for salaries outside the profile limits', function () {
        $band = SalaryBand::make(100000, 140000);

        expect($band->jobStart)->toBe(66.67)
            ->and($band->jobWidth)->toBe(33.33)
            ->and($band->targetStart)->toBeNull()
            ->and($band->fit)->toBeNull();
    });

    it('returns nothing when the salary is not listed', function () {
        expect(SalaryBand::make(0, 0, 40000, 60000))->toBeNull();
    });
});
