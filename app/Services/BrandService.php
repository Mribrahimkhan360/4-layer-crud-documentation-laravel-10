<?php


namespace App\Services;


use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository =  $brandRepository;
    }
    public function getAllBrands()
    {
        return $this->brandRepository->all();
    }

    public function findBrandById($id)
    {
        return $this->brandRepository->find($id);
    }

    public function createBrand(array $data)
    {
        return $this->brandRepository->store([
            'name' => $data['name'],
        ]);
    }

    public function updateBrand($id, array $data)
    {
        return $this->brandRepository->update(
            $id,[
            'name' => $data['name'],
        ]);
    }

    public function deleteBrand($id)
    {
        return $this->brandRepository->delete($id);
    }
}
