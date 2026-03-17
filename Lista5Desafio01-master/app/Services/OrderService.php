<?php

namespace App\Services;

use App\Domain\Orders\OrderRepositoryInterface;
use App\Domain\Users\UserRepositoryInterface;
use App\Domain\Orders\OrderStatus;
use App\Jobs\SendOrderNotificationJob;
use Exception;

class OrderService
{
    private $order_repository;
    private $user_repository;

    public function __construct(OrderRepositoryInterface $order_repository, UserRepositoryInterface $user_repository)
    {
        $this->order_repository = $order_repository;
        $this->user_repository = $user_repository;
    }

    public function create(array $data)
    {
        $data['status'] = OrderStatus::PENDING->value;
        $user = $this->user_repository->findById($data['user_id']);

        if(!$user){
            throw new Exception('Erro: usuario nao encontrado ao criar pedido',404);
        }
            

        $order = $this->order_repository->create($data);

        SendOrderNotificationJob::dispatch($user,$order);

        return $order;
    }

    public function update(string $id, array $data)
    {
        $order_id = $this->order_repository->findById($id);
        if(!$order_id){
            return new Exception("Erro: Pedido nao encontrado",404);
        }
        
        $order = $this->order_repository->update($id,$data);
        
        return $order;
    }

    public function findAll()
    {
        return $this->order_repository->findAll();
    }
}