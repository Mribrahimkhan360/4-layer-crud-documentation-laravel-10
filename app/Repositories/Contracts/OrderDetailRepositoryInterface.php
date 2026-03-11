<?php

namespace App\Repositories\Contracts;

interface OrderDetailRepositoryInterface
{
    public function storeMany($orderId, array $products);
    public function deleteByOrder($orderId);
}
