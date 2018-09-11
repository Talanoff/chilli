<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Review\Review;

class CommonController extends Controller
{
    public function home()
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
}
