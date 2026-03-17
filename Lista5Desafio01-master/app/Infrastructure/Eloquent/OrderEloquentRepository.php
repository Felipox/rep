<?php

namespace App\Infrastructure\Eloquent;

use App\Domain\Orders\OrderEntity;
use App\Domain\Orders\OrderRepositoryInterface;
use App\Models\Order;
use App\Domain\Orders\OrderStatus;

class OrderEloquentRepository implements OrderRepositoryInterface
{
    private $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function create(array $data): OrderEntity
    {
        $order_model = $this->model->create($data);
        return $this->toEntity($order_model);
    }

    public function findById(string $id): ?OrderEntity
    {
        $order_model = $this->model->where('id', $id)->first();
        if(!$order_model)
            {
                return null;
            }
        return $this->toEntity($order_model);
    }

    public function update(string $id, array $data): ?OrderEntity
    {
        $order_id = $this->model->where('id', $id)->first();

        if(!$order_id){
            return null;
        }

        $order_id->update($data);

        return $this->toEntity($order_id);

    }

    public function findAll(): array
    {
        $orders = $this->model->all();

        return $orders->map(fn($order) => $this->toEntity($order))->all();
    }

    private function toEntity(Order $model)
    {
        return new OrderEntity(
            $model->id,
            $model->user_id,
            $model->product_name,
            $model->amount,
            Orderstatus::from($model->status)
        );
    }
}