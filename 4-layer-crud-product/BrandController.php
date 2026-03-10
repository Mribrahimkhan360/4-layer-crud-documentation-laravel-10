<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Services\BrandService;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;

        // Only admin with 'manage-brand' permission can access
        $this->middleware(['auth', 'permission:manage-brand']);
    }

    public function index()
    {
        $brands = $this->brandService->getAllBrands();
        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(BrandStoreRequest $request)
    {
        $this->brandService->createBrand($request->validated());
        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function edit($id)
    {
        $brand = $this->brandService->findBrandById($id);
        return view('brands.edit', compact('brand'));
    }

    public function update(BrandUpdateRequest $request, $id)
    {
        $this->brandService->updateBrand($id, $request->validated());
        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy($id)
    {
        $this->brandService->deleteBrand($id);
        return redirect()->back()->with('success', 'Brand deleted successfully.');
    }
}
