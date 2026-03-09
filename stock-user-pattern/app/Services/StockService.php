<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\StockRepositoryInterface;

class StockService
{
    protected $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    /*
    |--------------------------------------------------------------------------
    | getAllStocks — delegates to Repository
    |--------------------------------------------------------------------------
    */

    public function getAllStocks()
    {
        return $this->stockRepository->all();
    }

    /*
    |--------------------------------------------------------------------------
    | getAllProductsWithBrand — for create/edit form dropdown
    |--------------------------------------------------------------------------
    */

    public function getAllProductsWithBrand()
    {
        return Product::with('brand')
            ->orderBy('name')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | findStockById — delegates to Repository
    |--------------------------------------------------------------------------
    */

    public function findStockById($id)
    {
        return $this->stockRepository->find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | createBulkStocks — business logic: build rows → bulkStore via Repository
    |--------------------------------------------------------------------------
    */

    public function createBulkStocks(array $data)
    {
        $productId     = (int) $data['product_id'];
        $serialNumbers = $data['serial_number'];

        $rows = array_map(fn(string $sn) => [
            'product_id'    => $productId,
            'serial_number' => trim($sn),
            'created_at'    => now(),
            'updated_at'    => now(),
        ], $serialNumbers);

        return $this->stockRepository->bulkStore($rows);
    }

    /*
    |--------------------------------------------------------------------------
    | updateStock — business logic: update single stock via Repository
    |--------------------------------------------------------------------------
    */

    public function updateStock($id, array $data)
    {
        return $this->stockRepository->update($id, [
            'product_id'    => $data['product_id'],
            'serial_number' => trim($data['serial_number']),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | deleteStock — delegates to Repository
    |--------------------------------------------------------------------------
    */

    public function deleteStock($id)
    {
        return $this->stockRepository->delete($id);
    }
}
