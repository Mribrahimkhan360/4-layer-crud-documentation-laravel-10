<?php


namespace App\Repositories\Eloquents;


use App\Models\Order;
use App\Repositories\Contracts\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    protected $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    public function all()
    {
        return $this->model->with(['user','order'])->orderBy('name')->latest()->get();
    }

    public function allByUser($userId)
    {
        return $this->model->with('orderDetails')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function find($id)
    {
        return $this->model->with(['user', 'orderDetails'])->findOrFail($id);
    }
}
