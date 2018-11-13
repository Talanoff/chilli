<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\FastBuyRequest;
use App\Mail\FastBuy;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FastBuyController extends Controller
{
    /**
     * @param FastBuyRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(FastBuyRequest $request, Product $product)
    {
        $user = Auth::check() ? Auth::user()->toArray() : $request->only('name', 'email', 'phone');

        Mail::to(env('ADMIN_EMAIL'))->send(new FastBuy($product, $user));

        return redirect()->route('app.fast-buy.details', $product);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details(Product $product)
    {
        return \view('app.cart.fast-buy', compact('product'));
    }
}
