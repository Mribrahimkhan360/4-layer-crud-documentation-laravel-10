<?php

use App\Http\Controllers\ProductOrderController;
use Illuminate\Support\Facades\Route;

Route::resource('product-orders', ProductOrderController::class);
