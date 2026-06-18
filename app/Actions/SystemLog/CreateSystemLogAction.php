<?php

namespace App\Actions\SystemLog;

use App\Models\SystemLog;

class CreateSystemLogAction
{
    /**
     * @param  array<string, string|int|array<string, mixed>>  $context
     */
    public function execute(int $userId, string $message, array $context): void
    {
        SystemLog::create([
            'user_id' => $userId,
            'text' => $message,
            'context' => $context,
        ]);
    }
}
