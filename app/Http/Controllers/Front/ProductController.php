<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\FastBuyRequest;
use App\Mail\FastBuy;
use App\Models\Meta\Meta;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\CharacteristicType;
use App\Models\Product\Product;
use App\Models\Product\Series;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $title = 'Каталог';

        $latest = null;
        $series = [];
        $query = Product::query();

        if ($request->filled('price')) {
            $query = $query->orderBy('price', $request->get('price'));
        }

        if ($request->filled('brand')) {
            $query = $query->whereHas('brand', function ($q) use ($request) {
                $q->whereSlug($request->get('brand'));
            });

            $series = Series::has('products')
                            ->whereHas('brand', function ($q) use ($request) {
                                $q->whereSlug($request->get('brand'));
                            })->get();
        }

        if ($request->filled('model') && $request->get('model') !== 'any') {
            $query = $query->whereHas('series', function ($q) use ($request) {
                $q->whereSlug($request->get('model'));
            });
        }

        if ($request->filled('category')) {
            $query = $query->whereHas('category', function ($q) use ($request) {
                $q->whereSlug($request->get('category'));
            });
        }

        $latest = $query->latest()->first();
        $products = $query->where('id', '!=', optional($latest)->id);

        if ($request->filled('leaders')) {
            $products = $products->leaders();
        } else {
            $query = $query->latest();
        }

        if (app('router')->currentRouteNamed('app.promotions')) {
            $title = 'Акции';
            $products = $products->whereInStock(true);
            $latest = $query->whereInStock(true)->first();
        }

        if (app('router')->currentRouteNamed('app.novelties')) {
            $title = 'Новинки';
            $products = $products->whereTag('newest');
            $latest = $query->whereTag('newest')->first();
        }

        return \view('app.product.index', [
            'products' => $products->paginate(12),
            'latest' => $latest,
            'title' => $title,
            'viewed' => $this::handleViewedProducts(),
            'filters' => $this::createFilters(),
            'meta' => Meta::whereMetableId(0)->whereMetableType(Product::class)->first(),
            'series' => $series,
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

        $images = collect([]);
        $thumbnails = collect([]);

        $media->map(function ($i, $index) use ($images, $thumbnails) {
            $images->put($index, $i->getUrl('large'));
            $thumbnails->put($index, $i->getUrl('thumb'));
        });

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
            'images' => json_encode($images->toArray()),
            'thumbnails' => json_encode($thumbnails->toArray()),
            'meta' => $product->meta()->first(),
            'image' => $product->getFirstMediaUrl('product', 'medium') // for meta
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
            'status' => $user->hasRole('administrator') ? 'approved' : 'agreement',
        ]);

        if ($request->filled('rating')) {
            $product->ratings()->updateOrCreate([
                'user_id' => $user->id,
            ], [
                'rate' => $request->get('rating'),
                'user_id' => $user->id,
            ]);
        }

        \session()->flash('success', 'Комментарий успешно отправлен на модерацию.');

        return \back();
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public static function handleViewedProducts()
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

    public function fastBuy(FastBuyRequest $request, Product $product)
    {
        $user = Auth::check() ? Auth::user()->toArray() : $request->only('name', 'email', 'phone');

        Mail::to(env('ADMIN_EMAIL'))->send(new FastBuy($product, $user));
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

    /**
     * @return Collection
     */
    private static function createFilters(): Collection
    {
        $filters = collect([]);

        $filters->put('brands', Brand::query()->has('products')->get());
        $filters->put('categories', Category::query()->has('product')->get());

        $filters->put('price', collect([
            'asc' => 'От дешевых к дорогим',
            'desc' => 'От дорогих к дешевым',
        ]));

        return $filters;
    }
}
