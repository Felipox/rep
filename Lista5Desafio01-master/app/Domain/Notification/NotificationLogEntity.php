<?php

namespace App\Domain\Notification;

class NotificationLogEntity
{
    public string $id;
    public string $user_id;
    public string $order_id;
    public string $message;
    public NotificationStatus $status;
    public int $attempts;

    public function __construct(string $id, string $user_id, string $order_id, string $message, NotificationStatus $status, int $attempts)
    {
        $this->id= $id;
        $this->user_id= $user_id;
        $this->order_id= $order_id;
        $this->message= $message;
        $this->status= $status;
        $this->attempts= $attempts;
    }
}