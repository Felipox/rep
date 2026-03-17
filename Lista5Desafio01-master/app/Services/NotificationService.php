<?php
namespace App\Services;

use App\Domain\Notification\NotificationLogRepositoryInterface;

class NotificationService
{
    private $notification_repository;

    public function __construct(NotificationLogRepositoryInterface $notification_repository)
    {
        $this->notification_repository= $notification_repository;
    }

    public function findAllByuser(string $id)
    {
        return $this->notification_repository->findAllByUserId($id);
    }
}