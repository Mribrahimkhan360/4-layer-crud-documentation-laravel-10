<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $brands = $this->brandService->getAllBrands();
        return view('brands.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request)
    {
        //
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
