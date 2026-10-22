<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'module',
        'record_id',
        'ip_address',
        'user_agent',
        'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record($action, $module, $recordId = null, $details = null)
    {
        $user = Auth::user();
        return self::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'System/Guest',
            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'details' => is_array($details) ? json_encode($details, JSON_UNESCAPED_UNICODE) : $details,
        ]);
    }
}
