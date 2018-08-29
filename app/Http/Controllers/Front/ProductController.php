<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        if (app('router')->currentRouteNamed('app.product.promotion')) {
            //
        }

        return \view('app.product.index', [
            'products' => Product::query()->latest()->paginate(12),
        ]);
    }

    public function show(Product $product): View
    {
        return \view('app.product.show', [
            'product' => $product,
            'related' => Product::query()->where('id', '<>', $product->id)->take(4)->get(),
            'comments' => $product->comments
        ]);
    }
}
