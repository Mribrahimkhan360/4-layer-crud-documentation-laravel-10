<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockRepositoryInterface;

class StockService
{
    protected $stockRepository;
    protected $productRepository;

    public function __construct(
        StockRepositoryInterface   $stockRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->stockRepository   = $stockRepository;
        $this->productRepository = $productRepository;
    }

    public function getAllStocks()
    {
        return $this->stockRepository->all();
    }

    /**
     * Return all products (for select dropdown).
     */
    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    public function findStockById($id)
    {
        return $this->stockRepository->find($id);
    }

    /**
     * Create stock entries — one row per serial number.
     * $data['serial_numbers'] is an array of serial strings.
     */
    public function createStock(array $data)
    {
        $serials = array_filter(
            array_map('trim', $data['serial_numbers']),
            fn($s) => $s !== ''
        );

        return $this->stockRepository->storeMany((int) $data['product_id'], array_values($serials));
    }

    /**
     * Update a single serial number entry.
     */
    public function updateStock($id, array $data)
    {
        return $this->stockRepository->update($id, [
            'product_id'    => $data['product_id'],
            'serial_number' => $data['serial_number'],
        ]);
    }

    public function deleteStock($id)
    {
        return $this->stockRepository->delete($id);
    }
}
