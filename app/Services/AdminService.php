<?php


namespace App\Services;


use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AdminService
{
    protected $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAllProducts()
    {
        return $this->adminRepository->all();
    }

    public function getMyOrders()
    {
        return $this->adminRepository->allByUser(Auth::id());
    }

}
