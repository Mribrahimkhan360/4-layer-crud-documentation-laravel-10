<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockStoreRequest;
use App\Http\Requests\StockUpdateRequest;
use App\Services\StockService;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /*
    |--------------------------------------------------------------------------
    | index — list all stocks
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $stocks = $this->stockService->getAllStocks();
        return view('stocks.index', compact('stocks'));
    }

    /*
    |--------------------------------------------------------------------------
    | create — show create form with product dropdown
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $products = $this->stockService->getAllProductsWithBrand();
        return view('stocks.create', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | store — validate via StockStoreRequest, delegate to Service
    |--------------------------------------------------------------------------
    */

    public function store(StockStoreRequest $request)
    {
        $this->stockService->createBulkStocks($request->validated());

        $count = count($request->validated('serial_number'));

        return redirect()
            ->route('stocks.index')
            ->with('success', $count . ' stock entries created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | edit — show edit form for single stock
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $stock    = $this->stockService->findStockById($id);
        $products = $this->stockService->getAllProductsWithBrand();
        return view('stocks.edit', compact('stock', 'products'));
    }

    /*
    |--------------------------------------------------------------------------
    | update — validate via StockUpdateRequest, delegate to Service
    |--------------------------------------------------------------------------
    */

    public function update(StockUpdateRequest $request, $id)
    {
        $this->stockService->updateStock($id, $request->validated());
        return redirect()
            ->route('stocks.index')
            ->with('success', 'Stock entry updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | destroy — delete stock entry
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $this->stockService->deleteStock($id);
        return redirect()
            ->back()
            ->with('success', 'Stock entry deleted successfully.');
    }
}
