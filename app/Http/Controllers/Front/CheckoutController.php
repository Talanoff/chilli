<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order\Checkout;
use App\Models\Order\Order;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use LisDev\Delivery\NovaPoshtaApi2;

class CheckoutController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $cart = CartController::handleUserCart();

        if (!$cart->count()) {
            return redirect()->route('app.product.index');
        }

        return \view('app.cart.checkout', [
            'cart' => $cart,
            'amount' => $cart->map(function ($item) {
                return $item->product->price * $item->quantity;
            })->sum(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $cart = CartController::handleUserCart();

        if (!Auth::check()) {
            $user = User::query()->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'birthday' => $request->get('birthday'),
                'password' => bcrypt(str_random(16)),
            ]);
        }

        /** @var Order $order */
        $order = Order::query()->create([
            'user_id' => $user->id,
            'delivery' => $request->get('delivery'),
            'message' => $request->get('message'),
        ]);

        $cart->map(function ($item) use ($user, $order) {
            Checkout::find($item->id)->update([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'status' => 'processing',
            ]);
        });

        if ($request->get('delivery') === 'np') {
            $order->update($request->only('city', 'warehouse'));
        } elseif ($request->get('delivery') === 'courier') {
            $order->update($request->only('address'));
        }

        return \redirect()->route('app.checkout.details');
    }

    /**
     * @return View
     */
    public function details(): View
    {
        if (!Auth::check()) {
            return redirect()->route('app.home');
        }

        return \view('app.cart.details', [
            'order' => Auth::user()->order()->latest()->first(),
        ]);
    }

    /**
     * Get cities list from NovaPoshta API
     * @return JsonResponse
     */
    public function getCities(): JsonResponse
    {
        /** @var NovaPoshtaApi2 $np */
        $np = new NovaPoshtaApi2(
            env('NOVAPOSHTA_API_KEY'),
            'ru'
        );

        return \response()->json($np->getCities());
    }

    /**
     * Get warehouses list for city ref from NovaPoshta API
     * @param $ref
     * @return JsonResponse
     */
    public function getWarehouses($ref): JsonResponse
    {
        /** @var NovaPoshtaApi2 $np */
        $np = new NovaPoshtaApi2(
            env('NOVAPOSHTA_API_KEY'),
            'ru'
        );

        return \response()->json($np->getWarehouses($ref));
    }
}
