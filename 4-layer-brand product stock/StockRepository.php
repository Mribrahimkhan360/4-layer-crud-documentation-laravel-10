<?php

namespace App\Repositories\Eloquent;

use App\Models\Stock;
use App\Repositories\Contracts\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
    protected $model;

    public function __construct(Stock $stock)
    {
        $this->model = $stock;
    }

    /**
     * Return all stock entries with product & brand.
     */
    public function all()
    {
        return $this->model->with('product.brand')->orderBy('id', 'desc')->get();
    }

    /**
     * Bulk-insert multiple serial numbers for a product.
     * Returns the collection of created records.
     */
    public function storeMany(int $productId, array $serialNumbers)
    {
        $now     = now();
        $inserts = array_map(fn($sn) => [
            'product_id'    => $productId,
            'serial_number' => $sn,
            'created_at'    => $now,
            'updated_at'    => $now,
        ], $serialNumbers);

        $this->model->insert($inserts);

        return $this->getByProduct($productId);
    }

    /**
     * Find a single stock entry by ID.
     */
    public function find($id)
    {
        return $this->model->with('product.brand')->findOrFail($id);
    }

    /**
     * Update a stock entry (serial number only).
     */
    public function update($id, array $data)
    {
        $stock = $this->find($id);
        $stock->update($data);
        return $stock;
    }

    /**
     * Delete a stock entry by ID.
     */
    public function delete($id)
    {
        $stock = $this->find($id);
        return $stock->delete();
    }

    /**
     * Get all stock entries for a given product.
     */
    public function getByProduct(int $productId)
    {
        return $this->model
            ->where('product_id', $productId)
            ->orderBy('serial_number')
            ->get();
    }
}
