<?php

namespace App\Enums;

enum JobSiteEnum: int
{
    case REED = 1;
    case LARAJOBS = 2;

    public function name(): string
    {
        return match ($this) {
            self::REED     => 'Reed',
            self::LARAJOBS => 'Larajobs',
        };
    }
}
