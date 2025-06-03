<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogger
{
    public static function log($activity, $module = null)
    {
        $user = Auth::user();

        DB::table('log_aktivitas')->insert([
            'user_id'     => $user ? $user->id : null,
            'username'    => $user ? $user->name : 'Guest',
            'activity'    => $activity,
            'module'      => $module,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::header('User-Agent'),
            'logged_at'   => now(),
        ]);
    }
}
