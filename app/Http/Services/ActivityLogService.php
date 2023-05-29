<?php

namespace App\Http\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public function createLog($userId, $model, $action, $ip, $data)
    {
        $data = json_encode($data);

        ActivityLog::create([
            'user_id' => $userId,
            'model' => $model,
            'action' => $action,
            'ip' => $ip,
            'data' => $data,
        ]);
    }
}
