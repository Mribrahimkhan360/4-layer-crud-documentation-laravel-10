<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = $this->permissionService->getAllPermissions();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionStoreRequest $request)
    {
        $this->permissionService->createPermission($request->validated());
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = $this->permissionService->findPermissionById($id);
        return view('permissions.edit', compact('permission'));
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
        $this->permissionService->updatePermission($id, $request->validated());
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $this->permissionService->deletePermission($id);
        return redirect()->back()->with('success', 'Permission deleted successfully.');
    }
}
