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

        Mail::to(config('app.email'))->queue(new FastBuy($product, $user));

        session()->put('product', $product->getKey());

        return redirect()->route('app.fast-buy.details');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details()
    {
        if (!session()->get('product')) {
            return redirect()->route('app.home');
        }

        $product = Product::find(session()->get('product'));
        session()->forget('product');

        return \view('app.cart.fast-buy', compact('product'));
    }
}
