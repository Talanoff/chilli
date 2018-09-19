<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\FavouriteResource;
use App\Models\Order\Checkout;
use App\Models\Product\Favourite;
use App\Models\Product\Kit;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return \view('app.cart.cart', [
            'cart' => self::handleUserCart(),
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
        $cart = self::handleUserCart();

        return response()->json([]);

        return response()->json([
            'cart' => CartResource::collection($cart),
            'summary' => [
                'count' => $cart->sum('quantity'),
                'amount' => $cart->map(function ($item) {
                    if ($item->product_id) {
                        $amount = $item->product->computed_price * $item->quantity;
                    } else {
                        $amount = $item->kit->amount * $item->quantity;
                    }
                    return $amount;
                })->sum(),
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
        $cart = self::handleUserCart();

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
     * @param Kit $kit
     * @return JsonResponse
     */
    public function addKitToCart(Kit $kit): JsonResponse
    {
        $cart = self::handleUserCart();

        if (count($cart) && in_array($kit->id, $cart->pluck('kit_id')->toArray())) {
            $checkout = Auth::check() ? Auth::user()->checkout() : Checkout::anonymous();

            $checkout = $checkout->whereKitId($kit->id)->first();

            $checkout->update([
                'quantity' => $checkout->quantity + 1,
            ]);
        } else {
            Checkout::query()->create([
                'user_id' => Auth::check() ? Auth::user()->id : session()->getId(),
                'kit_id' => $kit->id,
                'quantity' => 1,
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

    /**
     * @return mixed
     */
    public static function handleUserCart()
    {
        return Auth::check() ? Auth::user()->cart()->latest()->get() : Checkout::anonymous()->latest()->get();
    }
}
