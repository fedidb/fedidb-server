<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    protected $guarded = [];

    protected $casts = [
        'nodeinfo' => 'array',
        'instance_data' => 'array',
        'first_seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'robots_last_checked' => 'datetime',
        'crawl_state' => 'integer',
        'blocked_by_robots' => 'integer',
    ];
}
