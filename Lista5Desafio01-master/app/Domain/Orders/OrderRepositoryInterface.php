<?php

namespace App\Domain\Orders;

use App\Domain\Orders\OrderEntity;

interface OrderRepositoryInterface
{
    public function findById(string $id): ?OrderEntity;
    public function create(array $data): OrderEntity;
    public function update(string $id, array $data): ?OrderEntity;
    public function findAll(int $per_page=2);
}