<?php

namespace App\Repositories\Eloquent;

use App\Models\Purchase;
use App\Repositories\Contracts\PurchaseRepositoryInterface;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    protected $model;

    public function __construct(Purchase $purchase)
    {
        $this->model = $purchase;
    }

    public function all()
    {
        return $this->model->with(['user', 'product.brand'])->latest()->get();
    }

    public function allByUser($userId)
    {
        return $this->model->with(['product.brand'])->where('user_id', $userId)->latest()->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->with(['user', 'product.brand'])->findOrFail($id);
    }
}
