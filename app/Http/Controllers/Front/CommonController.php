<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function home()
    {
        $products = Product::query()
            ->orderByRaw("FIELD(tag , 'absolute_hit') DESC")
            ->orderByRaw("FIELD(tag , 'special_offer') DESC")
            ->orderByRaw("FIELD(tag , 'newest') DESC")
            ->take(7)->latest()->get();

        return \view('app.home.index', compact('products'));
    }
}
