<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.order.index', [
            'orders' => Order::latest()->paginate(20),
        ]);
    }

    /**
     * @param Order $order
     * @return View
     */
    public function show(Order $order): View
    {
        return \view('admin.order.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->only('status'));

        return \back();
    }
}
