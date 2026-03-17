<?php

namespace App\Jobs;

use App\Domain\Notification\NotificationLogRepositoryInterface;
use App\Domain\Notification\NotificationStatus;
use App\Domain\Orders\OrderEntity;
use App\Domain\Users\UserEntity;
use App\Mail\OrderNotification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderNotificationJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public $order;
    public $user;

    public function __construct(UserEntity $user, OrderEntity $order)
    {
        $this->user= $user;
        $this->order= $order;
    }

    public function handle(NotificationLogRepositoryInterface $log_repository): void
    {
        Mail::to($this->user->email)->send(    
        new OrderNotification($this->order, $this->user));

        $log_repository->create([
            'user_id'=> $this->user->id,
            'order_id'=> $this->order->id,
            'message'=> 'E-mail enviado com sucesso',
            'status'=> NotificationStatus::SENT->value,
            'attempts'=>$this->attempts()
        ]);
    }

    public function failed(\Throwable $exception)
    {
        $log_repository = app(NotificationLogRepositoryInterface::class);

        $log_repository->create([
            'user_id'=> $this->user->id,
            'order_id'=> $this->order->id,
            'message'=> $exception->getMessage(),
            'status'=> NotificationStatus::FAILED->value,
            'attempts'=>$this->attempts()
        ]);
    }
}
