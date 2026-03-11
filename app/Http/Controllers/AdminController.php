<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getMyOrders();
//        dd($orders->toArray());
        return view('admin.index',['orders' => $orders]);
    }
}
