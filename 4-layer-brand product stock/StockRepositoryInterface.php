<?php

namespace App\Repositories\Contracts;

interface StockRepositoryInterface
{
    public function all();
    public function storeMany(int $productId, array $serialNumbers);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function getByProduct(int $productId);
}
