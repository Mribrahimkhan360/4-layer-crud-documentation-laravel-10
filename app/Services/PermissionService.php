<?php


namespace App\Services;


use App\Repositories\Contracts\PermissionRepositoryInterface;

class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions()
    {
        return $this->permissionRepository->all();
    }

    public function findPermissionById($id)
    {
        return $this->permissionRepository->find($id);
    }

    public function createPermission(array $data)
    {
        return $this->permissionRepository->store([
            'name'       => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'web',
        ]);
    }

    public function updatePermission($id, array $data)
    {
        return $this->permissionRepository->update($id, [
            'name'       => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'web',
        ]);
    }

    public function deletePermission($id)
    {
        return $this->permissionRepository->delete($id);
    }
}
