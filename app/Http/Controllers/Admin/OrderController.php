<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        if ($request->filled('search')) {
            $orders = Order::where('id', ltrim($request->input('search'), '0'))
                           ->orWhereHas('user', function ($q) use ($request) {
                               $q->where('name', 'like', '%' . $request->input('search') . '%');
                           });
        }

        return \view('admin.order.index', [
            'orders' => $orders->paginate(20),
            'search' => $request->input('search'),
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

    /**
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->update($request->only('status'));

        return \back();
    }
}
