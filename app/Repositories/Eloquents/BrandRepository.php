<?php


namespace App\Repositories\Eloquents;


use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(Brand $brand)
    {
        $this->model = $brand;
    }

    //    Return all brand (with product count).
    public function all()
    {
        return $this->model->withCount('products')->orderBy('name')->get();
    }

    // create a new brand
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    // Find brand by ID or fail
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    // Update brand by ID
    public function update($id, array $data)
    {
        $brand = $this->find($id);
        $brand->update($data);
        return $brand;
    }

    // Delete brand by ID.
    public function delete($id)
    {
        $brand = $this->find($id);
        return $brand->delete();
    }
}
