<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use LisDev\Delivery\NovaPoshtaApi2;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!CartController::handleUserCart()->count()) {
            return redirect()->route('app.product.index');
        }

        return \view('app.cart.checkout', [
            'cart' => CartController::handleUserCart(),
        ]);
    }

    public function getCities(): JsonResponse
    {
        /** @var NovaPoshtaApi2 $np */
        $np = new NovaPoshtaApi2(
            env('NOVAPOSHTA_API_KEY'),
            'ru'
        );

        return response()->json([
            'cities' => $np->getCities(),
        ]);
    }

    public function getWarehouses($city, $state): JsonResponse
    {
        /** @var NovaPoshtaApi2 $np */
        $np = new NovaPoshtaApi2(
            env('NOVAPOSHTA_API_KEY'),
            'ru'
        );
        $current = $np->getCity($city, $state);

        return response()->json([
            'branches' => $np->getWarehouses($current),
        ]);
    }
}
