<?php

namespace App\Repositories\Eloquents;

use App\Models\Stock;
use App\Repositories\Contracts\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
    protected $model;

    public function __construct(Stock $stock)
    {
        $this->model = $stock;
    }

    /*
    |--------------------------------------------------------------------------
    | all — fetch all stocks with product and brand
    |--------------------------------------------------------------------------
    */

    public function all()
    {
        return $this->model
            ->with(['product.brand'])
            ->latest()
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | store — create a single stock entry
    |--------------------------------------------------------------------------
    */

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | find — find stock by id or fail
    |--------------------------------------------------------------------------
    */

    public function find($id)
    {
        return $this->model
            ->with(['product.brand'])
            ->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | update — update stock by id
    |--------------------------------------------------------------------------
    */

    public function update($id, array $data)
    {
        $stock = $this->find($id);
        $stock->update($data);
        return $stock;
    }

    /*
    |--------------------------------------------------------------------------
    | delete — delete stock by id
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $stock = $this->find($id);
        return $stock->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | bulkStore — insert multiple serial number rows at once
    |--------------------------------------------------------------------------
    */

    public function bulkStore(array $rows)
    {
        return $this->model->insert($rows);
    }
}
