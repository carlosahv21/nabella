<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    public static function log(string $event, string $table, int $recordId, )
    {
        DB::table('audit_logs')->insert([
            'event' => $event,
            'table_name' => $table,
            'record_id' => $recordId,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);
    }
}
