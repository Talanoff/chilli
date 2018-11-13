<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
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
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Show products default view
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $title = 'Каталог';
        $latest = null;

        list($latest, $products, $series) = $this->filters($request, Product::latest());

        return \view('app.product.index', $this->indexViewData($products, $latest, $title, $series));
    }

    /**
     * Show products which in stock
     * @param Request $request
     * @return View
     */
    public function promotions(Request $request): View
    {
        $title = 'Акции';
        $latest = null;

        $products = Product::whereInStock(true)->where('id', '!=', optional($latest)->id);

        list($latest, $products, $series) = $this->filters($request, $products);

        return \view('app.product.index', $this->indexViewData($products, $latest, $title, $series));
    }

    /**
     * Show novelties
     * @param Request $request
     * @return View
     */
    public function novelties(Request $request): View
    {
        $title = 'Новинки';
        $latest = null;

        $products = Product::whereTag('newest')->where('id', '!=', optional($latest)->id);

        list($latest, $products, $series) = $this->filters($request, $products);

        return \view('app.product.index', $this->indexViewData($products, $latest, $title, $series));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $search = trim($request->get('search'));

        $products = Product::query();

        if (intval($search) > 0) {
            $products = $products->where('id', '=', intval($search) - 1000);
        }

        $products = $products->orWhere('title', 'like', "%{$search}%")
                             ->orWhere('subtitle', 'like', "%{$search}%")
                             ->orWhereHas('brand', function ($q) use ($search) {
                                 $q->where('title', 'like', "%{$search}%");
                             });

        return \view('app.search.index', [
            'products' => $products->paginate(12),
            'viewed' => ProductController::handleViewedProducts(),
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

    /**
     * @param Request $request
     * @param $products
     * @return array
     */
    private function filters(Request $request, $products): array
    {
        $series = collect([]);

        if ($request->filled('price')) {
            $products = $products->orderBy('price', $request->get('price'));
        }

        if ($request->filled('brand')) {
            $products = $products->whereHas('brand', function ($q) use ($request) {
                $q->whereSlug($request->get('brand'));
            });

            $series = Series::has('products')
                            ->whereHas('brand', function ($q) use ($request) {
                                $q->whereSlug($request->get('brand'));
                            })->get();
        }

        if ($request->filled('model') && $request->get('model') !== 'any') {
            $products = $products->whereHas('series', function ($q) use ($request) {
                $q->whereSlug($request->get('model'));
            });
        }

        if ($request->filled('category')) {
            $products = $products->whereHas('category', function ($q) use ($request) {
                $q->whereSlug($request->get('category'));
            });
        }

        if ($request->has('leaders')) {
            $products = $products->leaders();
        }

        $latest = $products->first();
        $products = $products->where('id', '!=', optional($latest)->id);

        return [$latest, $products, $series];
    }

    /**
     * @param $products
     * @param $latest
     * @param $title
     * @param $series
     * @return array
     */
    private function indexViewData($products, $latest, $title, $series): array
    {
        return [
            'products' => $products->paginate(12),
            'latest' => $latest,
            'title' => $title,
            'viewed' => $this::handleViewedProducts(),
            'filters' => $this::createFilters(),
            'meta' => Meta::whereMetableId(0)->whereMetableType(Product::class)->first(),
            'series' => $series,
        ];
    }
}
