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
        BrandRepositoryInterface $brandRepository
    ) {
        $this->productRepository = $productRepository;
        $this->brandRepository   = $brandRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    public function getProductsByBrand($brandId)
    {
        return $this->productRepository->allByBrand($brandId);
    }

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
            'brand_id'    => $data['brand_id'],
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'is_active'   => $data['is_active'] ?? true,
        ]);
    }

    public function updateProduct($id, array $data)
    {
        return $this->productRepository->update($id, [
            'brand_id'    => $data['brand_id'],
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'is_active'   => $data['is_active'] ?? true,
        ]);
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }
}
