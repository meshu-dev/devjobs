<?php

namespace App\View;

use Illuminate\Support\Number;

/**
 * Positions a job's salary range against the user's target range on a shared
 * scale (the profile salary limits), so both can be drawn as one small bar.
 */
final class SalaryBand
{
    public const string BELOW = 'below';

    public const string WITHIN = 'within';

    public const string ABOVE = 'above';

    private function __construct(
        public readonly float $jobStart,
        public readonly float $jobWidth,
        public readonly ?float $targetStart,
        public readonly ?float $targetWidth,
        public readonly ?string $fit,
        public readonly string $label,
    ) {}

    public static function make(int $jobMin, int $jobMax, ?int $targetMin = null, ?int $targetMax = null): ?self
    {
        // Matches GetJobSalaryAction: anything under five figures is shown as N/A
        if ($jobMin < 10000 || $jobMax < 10000) {
            return null;
        }

        $scaleMin = (int) config('users.min_salary_limit');
        $scaleMax = (int) config('users.max_salary_limit');

        $hasTarget = $targetMin !== null && $targetMax !== null && $targetMax > $targetMin;

        // Widen the scale when a job or target falls outside the profile limits
        $scaleMin = min($scaleMin, $jobMin, $hasTarget ? $targetMin : $jobMin);
        $scaleMax = max($scaleMax, $jobMax, $hasTarget ? $targetMax : $jobMax);
        $span = max($scaleMax - $scaleMin, 1);

        $position = fn (int $value): float => round(($value - $scaleMin) / $span * 100, 2);

        $fit = null;
        $label = self::money($jobMin).' to '.self::money($jobMax).'.';

        if ($hasTarget) {
            $fit = match (true) {
                $jobMax < $targetMin => self::BELOW,
                $jobMin > $targetMax => self::ABOVE,
                default => self::WITHIN,
            };

            $label .= ' '.match ($fit) {
                self::BELOW => 'Below',
                self::ABOVE => 'Above',
                self::WITHIN => 'Overlaps',
            }.' your target of '.self::money($targetMin).' to '.self::money($targetMax).'.';
        }

        return new self(
            jobStart: $position($jobMin),
            // Keep very narrow ranges visible
            jobWidth: max($position($jobMax) - $position($jobMin), 2),
            targetStart: $hasTarget ? $position($targetMin) : null,
            targetWidth: $hasTarget ? $position($targetMax) - $position($targetMin) : null,
            fit: $fit,
            label: $label,
        );
    }

    private static function money(int $value): string
    {
        return '£'.Number::abbreviate($value);
    }
}
