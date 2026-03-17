<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasUuids;
    protected $fillable = [
        'user_id',
        'order_id',
        'message',
        'status',
        'attempts'
    ];
}
