<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Models\Page\Page;
use App\Models\Product\Product;
use App\Models\Review\Review;
use App\Models\User\Subscribe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @param SubscribeRequest $request
     * @return RedirectResponse
     */
    public function subscribe(SubscribeRequest $request): RedirectResponse
    {
        Subscribe::query()->create($request->only('email'));

        session()->flash('success', 'Ваш e-mail успешно добавлен в нашу базу');

        return \back();
    }

    public function page(Page $page): View
    {
        return \view('app.page.show', [
            'page' => $page,
            'meta' => $page->meta()->first(),
        ]);
    }
}
