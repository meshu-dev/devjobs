<?php

namespace App\View;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

final class JobDates
{
    /**
     * "Today", "Yesterday" or a full day name such as "Tuesday 17 November".
     */
    public static function day(CarbonInterface|string $date): string
    {
        $date = Carbon::parse($date);

        return match (true) {
            $date->isToday() => 'Today',
            $date->isYesterday() => 'Yesterday',
            $date->isCurrentYear() => $date->format('l j F'),
            default => $date->format('l j F Y'),
        };
    }

    /**
     * A short date for compact places, such as "20 Nov" or "20 Nov 2025".
     */
    public static function short(CarbonInterface|string $date): string
    {
        $date = Carbon::parse($date);

        return $date->isCurrentYear() ? $date->format('j M') : $date->format('j M Y');
    }

    /**
     * When the daily import next runs, such as "today at 15:00".
     */
    public static function nextImport(): string
    {
        $time = (string) config('jobs.import_time');
        $next = Carbon::parse('today '.$time);

        return ($next->isFuture() ? 'today' : 'tomorrow').' at '.$next->format('H:i');
    }
}
