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

    public function index()
    {
        $stocks = $this->stockService->getAllStocks();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $products = $this->stockService->getAllProducts();
        return view('stocks.create', compact('products'));
    }

    public function store(StockStoreRequest $request)
    {
        $this->stockService->createStock($request->validated());
        return redirect()->route('stocks.index')->with('success', 'Stock entries added successfully.');
    }

    public function edit($id)
    {
        $stock    = $this->stockService->findStockById($id);
        $products = $this->stockService->getAllProducts();
        return view('stocks.edit', compact('stock', 'products'));
    }

    public function update(StockUpdateRequest $request, $id)
    {
        $this->stockService->updateStock($id, $request->validated());
        return redirect()->route('stocks.index')->with('success', 'Stock entry updated successfully.');
    }

    public function destroy($id)
    {
        $this->stockService->deleteStock($id);
        return redirect()->back()->with('success', 'Stock entry deleted successfully.');
    }
}
