<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getAllPermissions();
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleStoreRequest $request)
    {
        $this->roleService->createRole($request->validated());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role        = $this->roleService->findRoleById($id);
        $permissions = $this->roleService->getAllPermissions();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $this->roleService->updateRole($id, $request->validated());
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $this->roleService->deleteRole($id);
        return redirect()->back()->with('success', 'Role deleted successfully.');
    }
}
