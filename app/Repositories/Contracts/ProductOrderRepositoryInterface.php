<?php


namespace App\Repositories\Contracts;


interface ProductOrderRepositoryInterface
{
    public function all();
    public function store(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function bulkStore(array $rows);
}
