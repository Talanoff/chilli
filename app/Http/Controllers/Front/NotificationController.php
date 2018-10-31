<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\Notification;
use App\Models\Product\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function add(Request $request, Product $product): RedirectResponse
    {
        if (!Auth::check()) {
            $data = [
                'email' => $request->get('email'),
                'product_id' => $product->id,
            ];
        } else {
            $data = [
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
            ];
        }

        Notification::create($data);

        return \back();
    }
}
