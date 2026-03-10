<?php

namespace App\Repositories\Eloquents;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * Return all products with brand and stock count.
     */
    public function all()
    {
        return $this->model->with('brand')->withCount('stocks')->orderBy('name')->get();
    }

    /**
     * Create a new product.
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find product by ID or fail (with brand eager loaded).
     */
    public function find($id)
    {
        return $this->model->with('brand')->findOrFail($id);
    }

    /**
     * Update product by ID.
     */
    public function update($id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    /**
     * Delete product by ID.
     */
    public function delete($id)
    {
        $product = $this->find($id);
        return $product->delete();
    }
}
