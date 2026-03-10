<?php

namespace App\Repositories\Contracts;

interface PurchaseRepositoryInterface
{
    public function all();
    public function allByUser($userId);
    public function store(array $data);
    public function find($id);
}
