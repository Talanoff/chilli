<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\UserRegister;
use App\Models\Order\Order;
use App\Models\User\User;
use App\Services\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use LisDev\Delivery\NovaPoshtaApi2;

class CheckoutController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|View
     */
    public function index()
    {
        $cart = new Cart();

        if (!$cart->items()->count()) {
            return redirect()->route('app.product.index');
        }

        return \view('app.cart.checkout', [
            'cart' => $cart->items(),
            'amount' => $cart->amount(),
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

        if (!Auth::check()) {
            $password = str_random(8);

            $user = User::query()->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => str_replace([' ', '(', ')', '-'], '', $request->get('phone')),
                'password' => bcrypt($password),
                'role_id' => 2,
            ]);

            Mail::send(new UserRegister($user, $password));

            Auth::login($user);
        }

        /** @var Order $order */
        $order = Order::query()->create([
            'user_id' => $user->id,
            'delivery' => $request->get('delivery'),
            'message' => $request->get('message'),
            'city' => $request->get('city'),
            'warehouse' => $request->get('warehouse'),
            'address' => $request->get('address'),
        ]);

        (new Cart())->complete($user, $order);

        return \redirect()->route('app.checkout.details');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|View
     */
    public function details()
    {
        if (!Auth::check()) {
            return redirect()->route('app.home');
        }

        return \view('app.cart.details', [
            'order' => Auth::user()->orders()->latest()->first(),
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
