<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Order\Checkout;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get all cart items
     *
     * @return JsonResponse
     */
    public function getCart(): JsonResponse
    {
        $cart = $this->handleUserCart();

        return response()->json([
            'cart' => CartResource::collection($cart),
            'summary' => [
                'count' => $cart->sum('quantity'),
                'summary' => $cart->map(function ($item) {
                    return $item->product->price * $item->quantity;
                })->sum(),
            ],
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function addProductToCart(Product $product): JsonResponse
    {
        $cart = $this->handleUserCart();

        if (in_array($product->id, $cart->pluck('product_id')->toArray())) {
            $checkout = Auth::check() ? Auth::user()->checkout() : Checkout::anonymous();

            $checkout = $checkout->whereProductId($product->id)->first();

            $checkout->update([
                'quantity' => $checkout->quantity + 1,
            ]);
        } else {
            Checkout::query()->create([
                'user_id' => Auth::check() ? Auth::user()->id : session()->getId(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return $this->getCart();
    }

    /**
     * @return mixed
     */
    private function handleUserCart()
    {
        return Auth::check() ? Auth::user()->cart()->get() : Checkout::anonymous()->get();
    }
}
