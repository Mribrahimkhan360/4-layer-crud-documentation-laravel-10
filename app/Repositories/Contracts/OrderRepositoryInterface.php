<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function all();
    public function allByUser($userId);
    public function store(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
