<?php


namespace App\Services;


use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;

class RoleService
{
    protected $roleRepository;
    protected $permissionRepository;
    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository
    ) {
        $this->roleRepository       = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->all();
    }

    public function getAllPermissions()
    {
        return $this->permissionRepository->all();
    }

    public function findRoleById($id)
    {
        return $this->roleRepository->find($id);
    }

    public function createRole(array $data)
    {
        $role = $this->roleRepository->store([
            'name'  => $data['name'],
            'guard_name' => 'web',
        ]);
        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function updateRole($id, array $data)
    {
        $role = $this->roleRepository->update($id, [
            'name'       => $data['name'],
            'guard_name' => 'web',
        ]);

        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        } else {
            $role->syncPermissions([]);
        }

        return $role;
    }

    public function deleteRole($id)
    {
        return $this->roleRepository->delete($id);
    }
}
