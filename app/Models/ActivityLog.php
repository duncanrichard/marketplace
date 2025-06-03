<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'username', 'activity', 'module', 'ip_address', 'user_agent', 'logged_at'
    ];
}
