<?php

namespace App\Services;

use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;
    protected $brandRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        BrandRepositoryInterface   $brandRepository
    ) {
        $this->productRepository = $productRepository;
        $this->brandRepository   = $brandRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    /**
     * Return all brands (for select dropdown).
     */
    public function getAllBrands()
    {
        return $this->brandRepository->all();
    }

    public function findProductById($id)
    {
        return $this->productRepository->find($id);
    }

    public function createProduct(array $data)
    {
        return $this->productRepository->store([
            'brand_id' => $data['brand_id'],
            'name'     => $data['name'],
        ]);
    }

    public function updateProduct($id, array $data)
    {
        return $this->productRepository->update($id, [
            'brand_id' => $data['brand_id'],
            'name'     => $data['name'],
        ]);
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }
}
