<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\FavouriteResource;
use App\Models\Order\Checkout;
use App\Models\Product\Favourite;
use App\Models\Product\Kit;
use App\Models\Product\Product;
use App\Services\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return \view('app.cart.cart', [
            'cart' => (new Cart())->items(),
            'viewed' => ProductController::handleViewedProducts(),
        ]);
    }

    /**
     * Get all cart items
     *
     * @return JsonResponse
     */
    public function getCart(): JsonResponse
    {
        $cart = new Cart();

        return response()->json([
            'cart' => CartResource::collection($cart->items()),
            'summary' => [
                'count' => $cart->items()->sum('quantity'),
                'amount' => $cart->amount(),
            ],
            'favourites' => FavouriteResource::collection(Favourite::favourites()),
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function addProductToCart(Product $product): JsonResponse
    {
        $cart = (new Cart())->items();

        if ($cart->count() && $cart->keyBy('product_id')->has($product->getKey())) {
            $item = $cart->where('product_id', $product->getkey())->first();
            $item->update([
                'quantity' => $item->quantity + 1,
            ]);
        } else {
            Checkout::query()->create([
                'user_id' => Auth::check() ? Auth::user()->id : session()->getId(),
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->computed_price,
            ]);
        }

        return $this->getCart();
    }

    /**
     * @param Kit $kit
     * @return JsonResponse
     */
    public function addKitToCart(Kit $kit): JsonResponse
    {
        $cart = (new Cart())->items();

        if ($cart->count() && $cart->keyBy('kit_id')->has($kit->getKey())) {
            $item = $cart->where('kit_id', $kit->getkey())->first();
            $item->update([
                'quantity' => $item->quantity + 1,
            ]);
        } else {
            Checkout::query()->create([
                'user_id' => Auth::check() ? Auth::user()->id : session()->getId(),
                'kit_id' => $kit->id,
                'quantity' => 1,
                'price' => $kit->amount,
            ]);
        }

        return $this->getCart();
    }

    /**
     * @param Checkout $checkout
     * @param $action
     * @return JsonResponse
     */
    public function quantity(Checkout $checkout, $action): JsonResponse
    {
        if ($action === 'add') {
            $checkout->update([
                'quantity' => $checkout->quantity + 1,
            ]);
        } else {
            if ($action === 'remove' && $checkout->quantity > 1) {
                $checkout->update([
                    'quantity' => $checkout->quantity - 1,
                ]);
            }
        }

        return $this->getCart();
    }

    /**
     * @param Checkout $checkout
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Checkout $checkout): JsonResponse
    {
        $checkout->delete();

        return $this->getCart();
    }
}
