<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return \view('admin.order.index', [
            'orders' => Checkout::query()->latest()->paginate(20),
        ]);
    }
}
