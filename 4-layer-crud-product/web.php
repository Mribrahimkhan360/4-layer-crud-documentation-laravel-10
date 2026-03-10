<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes — requires 'manage-brand' or 'create-product' permission
|--------------------------------------------------------------------------
*/
Route::resource('brands',      BrandController::class);
Route::resource('products',    ProductController::class);
Route::resource('users',       UserController::class);
Route::resource('roles',       RoleController::class);
Route::resource('permissions', PermissionController::class)->except(['show']);

/*
|--------------------------------------------------------------------------
| Customer Routes — requires 'customer' role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/shop',         [PurchaseController::class, 'index'])->name('purchase.index');
    Route::post('/shop/buy',    [PurchaseController::class, 'store'])->name('purchase.store');
});
