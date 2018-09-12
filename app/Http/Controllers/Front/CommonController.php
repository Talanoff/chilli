<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Review\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommonController extends Controller
{
    /**
     * @return View
     */
    public function home(): View
    {
        $products = Product::query()
                           ->orderByRaw("FIELD(tag , 'absolute_hit') DESC")
                           ->orderByRaw("FIELD(tag , 'special_offer') DESC")
                           ->orderByRaw("FIELD(tag , 'newest') DESC")
                           ->take(6)->latest()->get();

        return \view('app.home.index', [
            'products' => $products,
            'reviews' => Review::query()->latest()->take(3)->get(),
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $products = Product::query()
                           ->where('title', 'like', "%{$request->get('search')}%")
                           ->orWhere('subtitle', 'link', "%{$request->get('search')}%")
                           ->orWhereHas('brand', function ($q) use ($request) {
                               $q->where('name', 'like', "%{$request->get('search')}%");
                           })
                           ->paginate(12);

        return \view('app.search.index', [
            'products' => $products,
            'viewed' => ProductController::handleViewedProducts()
        ]);
    }
}
