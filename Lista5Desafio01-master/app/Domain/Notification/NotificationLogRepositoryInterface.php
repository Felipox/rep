<?php

namespace App\Domain\Notification;

interface NotificationLogRepositoryInterface
{
    public function create(array $data): NotificationLogEntity;
    public function update(string $id, array $data): ?NotificationLogEntity;
    public function findByStatus(NotificationStatus $status): array;
    public function findAllByUserId(string $user_id): array;

}