<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Order\Checkout;
use App\Models\Product\Product;
use App\Models\User\User;
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
        /** @var User $user */
        $user = Auth::user();

        return response()->json([
            'cart' => Auth::check() ? CartResource::collection($user->cart()->get()) : Auth::check(),
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function addProductToCart(Product $product): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (in_array($product->id, $user->cart->pluck('product_id')->toArray())) {
            /** @var Checkout $checkout */
            $checkout = $user->checkout()->whereProductId($product->id)->first();

            $checkout->update([
                'quantity' => $checkout->quantity + 1,
            ]);
        } else {
            Checkout::query()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return $this->getCart();
    }
}
