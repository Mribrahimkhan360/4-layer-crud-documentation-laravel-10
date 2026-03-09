# Product Order — Laravel 4-Layer Architecture
# Pattern: UserController / UserService / UserRepository / UserRepositoryInterface

## ═══════════════════════════════════════════════════
## File Structure
## ═══════════════════════════════════════════════════

app/
├── Http/
│   ├── Controllers/
│   │   └── ProductOrderController.php
│   └── Requests/
│       ├── ProductOrderStoreRequest.php
│       └── ProductOrderUpdateRequest.php
├── Services/
│   └── ProductOrderService.php
├── Repositories/
│   ├── Contracts/
│   │   └── ProductOrderRepositoryInterface.php
│   └── Eloquent/
│       └── ProductOrderRepository.php
├── Models/
│   └── ProductOrder.php
└── Providers/
    └── AppServiceProvider.php

routes/
└── web.php

database/migrations/
└── create_product_orders_table.php

resources/views/product-orders/
├── index.blade.php    ← list all orders (edit / delete)
├── create.blade.php   ← jQuery append: select product + quantity (multiple rows)
└── edit.blade.php     ← edit single row

## ═══════════════════════════════════════════════════
## Setup Steps
## ═══════════════════════════════════════════════════

1. Copy all files into your Laravel project

2. Run migration:
      php artisan migrate

3. AppServiceProvider binding is already done:
      ProductOrderRepositoryInterface::class → ProductOrderRepository::class

4. Ensure jQuery is loaded in your layout:
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

5. Visit:
      /product-orders          → index
      /product-orders/create   → create with jQuery append

## ═══════════════════════════════════════════════════
## CRUD Flow
## ═══════════════════════════════════════════════════

CREATE (bulk — jQuery append)
   Browser POST /product-orders
       → ProductOrderStoreRequest   (validates product_id[] + quantity[])
       → ProductOrderController@store
       → ProductOrderService::createBulkOrders()  (zip arrays → $rows)
       → ProductOrderRepository::bulkStore()
       → ProductOrder::insert($rows)

READ
   Browser GET /product-orders
       → ProductOrderController@index
       → ProductOrderService::getAllOrders()
       → ProductOrderRepository::all()
       → ProductOrder::with(['product.brand'])->latest()->get()

UPDATE (single row)
   Browser PUT /product-orders/{id}
       → ProductOrderUpdateRequest   (validates product_id + quantity)
       → ProductOrderController@update
       → ProductOrderService::updateOrder()
       → ProductOrderRepository::update()

DELETE
   Browser DELETE /product-orders/{id}
       → ProductOrderController@destroy
       → ProductOrderService::deleteOrder()
       → ProductOrderRepository::delete()

## ═══════════════════════════════════════════════════
## jQuery Append Pattern
## ═══════════════════════════════════════════════════

Each row has:   <select name="product_id[]"> + <input name="quantity[]">

#add-row click       → append new row (product select + qty input + remove btn)
.remove-row click    → remove closest .order-row
updateCounter()      → update row count badge + renumber row labels
buildProductOptions()→ build <option> tags from inline JSON (no AJAX needed)
old() repopulation   → @foreach(old('product_id', [])) loop in blade
