<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PurchaseService
{
    protected $purchaseRepository;
    protected $productRepository;

    public function __construct(
        PurchaseRepositoryInterface $purchaseRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->purchaseRepository = $purchaseRepository;
        $this->productRepository  = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->all();
    }

    public function findProductById($id)
    {
        return $this->productRepository->find($id);
    }

    public function getMyPurchases()
    {
        return $this->purchaseRepository->allByUser(Auth::id());
    }

    public function purchaseProduct(array $data)
    {
        $product = $this->productRepository->find($data['product_id']);

        // Deduct stock
        $this->productRepository->update($product->id, [
            'brand_id'    => $product->brand_id,
            'name'        => $product->name,
            'description' => $product->description,
            'price'       => $product->price,
            'stock'       => $product->stock - $data['quantity'],
            'is_active'   => $product->is_active,
        ]);

        return $this->purchaseRepository->store([
            'user_id'     => Auth::id(),
            'product_id'  => $product->id,
            'quantity'    => $data['quantity'],
            'total_price' => $product->price * $data['quantity'],
            'status'      => 'pending',
        ]);
    }
}
