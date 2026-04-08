<?php

namespace App\Enums;

enum JobSiteEnum: int
{
    case REED = 1;
    case LARAJOBS = 2;
    case JOBLEADS = 3;

    public function name(): string
    {
        return match ($this) {
            self::REED     => 'Reed',
            self::LARAJOBS => 'Larajobs',
            self::JOBLEADS => 'Jobleads',
        };
    }

    public function url(): string
    {
        return match ($this) {
            self::REED     => 'https://www.reed.co.uk',
            self::LARAJOBS => 'https://larajobs.com',
            self::JOBLEADS => 'https://www.jobleads.com',
        };
    }
}
