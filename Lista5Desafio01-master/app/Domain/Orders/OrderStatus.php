<?php

namespace App\Domain\Orders;

enum OrderStatus: string
{
    case PENDING = 'PENDING';
    CASE PROCESSING = 'PROCESSING';
    CASE COMPLETED = 'COMPLETED';
}