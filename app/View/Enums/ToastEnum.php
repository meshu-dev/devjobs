<?php

namespace App\View\Enums;

enum ToastEnum: string
{
    case SUCCESS = 'success';

    public function getCss(): string
    {
        return match ($this) {
            self::SUCCESS => 'alert-' . self::SUCCESS->value,
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::SUCCESS => 'o-check-circle',
        };
    }
}
