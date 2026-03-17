<?php

namespace App\Domain\Notification;

enum NotificationStatus:string
{
    case SENT = 'SENT';
    case FAILED = 'FAILED';
}