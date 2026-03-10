<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(Brand $brand)
    {
        $this->model = $brand;
    }

    public function all()
    {
        return $this->model->withCount('products')->latest()->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->with('products')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $brand = $this->find($id);
        $brand->update($data);
        return $brand;
    }

    public function delete($id)
    {
        $brand = $this->find($id);
        return $brand->delete();
    }
}
