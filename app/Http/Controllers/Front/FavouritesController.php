<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavouriteResource;
use App\Models\Product\Favourite;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavouritesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('app.product.favourites', [
            'favourites' => Favourite::favourites(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return \response()->json(FavouriteResource::collection(Favourite::favourites()));
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function add(Product $product)
    {
        $product->favourites()->create([
            'user_id' => Auth::check() ? Auth::user()->id : session()->getId(),
        ]);

        return $this->list();
    }

    /**
     * @param Favourite $favourite
     * @return JsonResponse
     * @throws \Exception
     */
    public function remove(Favourite $favourite)
    {
        $favourite->delete();

        return $this->list();
    }
}
