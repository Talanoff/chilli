<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Product\CharacteristicType;
use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $title = 'Каталог';

        $query = Product::query()->latest();
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
        $characteristics = collect([]);
        $media = $product->getMedia('product');

        $images = $media->map(function ($i) {
            return $i->getUrl('large');
        })->toArray();

        $thumbnails = $media->map(function ($i) {
            return $i->getUrl('thumb');
        })->toArray();

        $this->addToViewedProducts($product);

        $types = $product->characteristics->filter(function ($attr) {
            return $attr->type !== 'color' && $attr->type !== 'image';
        })->pluck('type_id')->unique()->toArray();

        CharacteristicType::whereIn('id', $types)->get()->map(function ($type) use ($product, $characteristics) {
            $characteristics->put($type->title,
                $product->characteristics()->whereTypeId($type->id)->get()->pluck('value')->toArray());
        });

        return \view('app.product.show', [
            'title' => $product->title,
            'product' => $product,
            'characteristics' => $characteristics,
            'images' => json_encode($images),
            'thumbnails' => json_encode($thumbnails),
        ]);
    }

    /**
     * @param CommentRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(CommentRequest $request, Product $product)
    {
        if (!Auth::check()) {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt('secret'),
                'role_id' => 2,
            ]);
        } else {
            /** @var User $user */
            $user = Auth::user();
        }

        $product->comments()->create([
            'message' => $request->get('message'),
            'user_id' => $user->id,
        ]);

        if ($request->filled('rating')) {
            $product->ratings()->updateOrCreate([
                'user_id' => $user->id,
            ], [
                'rate' => $request->get('rating'),
                'user_id' => $user->id,
            ]);
        }

        session()->flash('success', 'Комментарий успешно отправлен на модерацию.');

        return \back();
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

    /**
     * @param Product $product
     */
    private function addToViewedProducts(Product $product): void
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
    }
}
