<?php

namespace App\Actions\Job;

use Illuminate\Support\Number;

class GetJobSalaryAction
{
    public function execute(int $minSalary, int $maxSalary, bool $abbreviated = false): string|int
    {
        if (strlen(strval($minSalary)) >= 5 && strlen(strval($maxSalary)) >= 5) {
            if ($abbreviated === true) {
                $symbol = '£';

                return $symbol.Number::abbreviate($minSalary).' - '.$symbol.Number::abbreviate($maxSalary);
            } else {
                return Number::currency($minSalary).' - '.Number::currency($maxSalary);
            }
        }

        return 'N/A';
    }
}
