<?php

namespace App\Support;

use App\Models\AdminAuditLog;
use Illuminate\Database\Eloquent\Model;

class AdminAudit
{
    public static function record(string $action, ?Model $target = null, array $metadata = []): void
    {
        try {
            AdminAuditLog::create([
                'admin_id' => auth('admin')->id(),
                'action' => $action,
                'target_type' => $target ? get_class($target) : null,
                'target_id' => $target?->getKey(),
                'metadata' => $metadata ?: null,
                'ip_address' => request()?->ip(),
                'user_agent' => substr((string) request()?->userAgent(), 0, 255),
            ]);
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
