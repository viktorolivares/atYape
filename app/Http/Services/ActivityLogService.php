<?php

namespace App\Http\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public function createLog($type, $email, $ip)
    {
        ActivityLog::create([
            'type' => $type,
            'email' => $email,
            'ip' => $ip
        ]);
    }
}
