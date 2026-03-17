<?php

namespace App\Domain\Orders;

class OrderEntity
{
    public string $id;
    public string $user_id;
    public string $product_name;
    public int $amount;
    public OrderStatus $status;


    public function __construct(string $id, string $user_id, string $product_name, int $amount, OrderStatus $status)
    {
        $this->id= $id;
        $this->user_id= $user_id;
        $this->product_name= $product_name;
        $this->amount= $amount;
        $this->status= $status;
    }
}