<?php

namespace App\Infrastructure\Eloquent;

use App\Domain\Notification\NotificationLogEntity;
use App\Domain\Notification\NotificationLogRepositoryInterface;
use App\Models\NotificationLog;
use App\Domain\Notification\NotificationStatus;


class NotificationLogEloquentRepository implements NotificationLogRepositoryInterface
{
    private $model;

    public function __construct(NotificationLog $model)
    {
        $this->model = $model;
    }

    public function create(array $data): NotificationLogEntity
    {
        $notification_model = $this->model->create($data);
        return $this->toEntity($notification_model);
    }

    public function update(string $id, array $data): ?NotificationLogEntity
    {
        $notification = $this->model->where('id',$id)->first();

        if(!$notification){
            return null;
        }

        $notification->update($data);

        return $this->toEntity($notification);    
    }

    public function findByStatus(NotificationStatus $status): array
    {
        $notification = $this->model->where('status',$status->value)->get();

        return $notification->map(fn(NotificationLog $log) => $this->toEntity($log))->all();
    }

    public function findAllByUserId(string $user_id): array
    {
        $notifications = $this->model->where('user_id',$user_id)->get();

        return $notifications->map(fn(NotificationLog $log) => $this->toEntity($log))->all();
    }

    private function toEntity(NotificationLog $model)
    {
        return new NotificationLogEntity(
        $model->id,
        $model->user_id,
        $model->order_id,
        $model->message,
        NotificationStatus::from($model->status),
        $model->attempts
        );
    }
}