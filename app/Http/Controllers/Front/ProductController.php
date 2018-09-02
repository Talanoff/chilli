<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $title = 'Каталог';

        $query = Product::query()->latest()->with(['attribute']);
        $latest = $query->first();
        $products = $query->where('id', '<', $latest->id);

        $viewed = $this->handleViewedProducts();

        if (app('router')->currentRouteNamed('app.promotions.index')) {
            $title = 'Акции';
            $products = $products->whereInStock(true);
            $latest = $query->whereInStock(true)->first();
        }

        if (app('router')->currentRouteNamed('app.novelties.index')) {
            $title = 'Новинки';
            $products = $products->whereTag('newest');
            $latest = $query->whereTag('newest')->first();
        }

        return \view('app.product.index', [
            'products' => $products->paginate(12),
            'latest' => $latest,
            'title' => $title,
            'viewed' => $viewed,
        ]);
    }

    /**
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        if (!session()->has('viewed')) {
            session()->put('viewed', []);
        }

        $viewed = session()->get('viewed');

        if (in_array($product->id, $viewed)) {
            array_splice($viewed, array_search($product->id, $viewed), 1);
            session()->put('viewed', $viewed);
        }

        session()->push('viewed', $product->id);

        return \view('app.product.show', [
            'product' => $product,
            'related' => Product::query()->where('id', '<>', $product->id)->take(4)->get(),
            'comments' => $product->comments()->get(),
        ]);
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    private function handleViewedProducts()
    {
        $viewed = [];
        if (session()->has('viewed')) {
            $items = array_reverse(session()->get('viewed'));

            $viewed = Product::query()
                             ->whereIn('id', array_slice($items, 0, 4))
                             ->take(4)->get();
        }
        return $viewed;
    }
}
