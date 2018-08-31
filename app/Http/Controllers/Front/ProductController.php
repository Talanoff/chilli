<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $title = 'Каталог';
        $products = Product::query()->latest();

        if (app('router')->currentRouteNamed('app.product.promotions')) {
            $products = $products->whereInStock(true);
            $title = 'Акции';
        }

        if (app('router')->currentRouteNamed('app.product.novelties')) {
            $products = $products->whereTag('newest');
            $title = 'Новинки';
        }

        return \view('app.product.index', [
            'products' => $products->paginate(12),
            'title' => $title,
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
