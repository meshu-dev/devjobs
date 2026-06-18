<?php

namespace App\View\Enums;

enum ToastEnum: string
{
    case SUCCESS = 'success';
    case ERROR   = 'error';

    public function getCss(): string
    {
        return match ($this) {
            self::SUCCESS => 'alert-' . self::SUCCESS->value,
            self::ERROR   => 'alert-' . self::ERROR->value,
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::SUCCESS => 'o-check-circle',
            self::ERROR   => 'o-check-circle',
        };
    }
}
