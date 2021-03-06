<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SeriesResource;
use App\Models\Meta\Meta;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\CharacteristicType;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Show all products
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $products = Product::query()->with('category');

        if ($request->filled('category')) {
            $products->where('category_id', '=', $request->get('category'));
        }

        if ($request->filled('search')) {
            $products = Product::where('id', ltrim($request->get('search'), '0'))
                               ->orWhere('title', 'like', '%' . $request->get('search') . '%')
                               ->orWhereHas('brand', function ($q) use ($request) {
                                   $q->where('title', 'like', '%' . $request->get('search') . '%');
                               });
        }

        return \view('admin.product.index', [
            'products' => $products->latest('id')->paginate(20),
            'search' => $request->get('search'),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json(ProductResource::collection(Product::latest()->get()));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return View
     */
    public function create(): View
    {
        return \view('admin.product.create', [
            'tags' => Product::$TAGS,
            'types' => CharacteristicType::all(),
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }

    /**
     * Store a newly created product.
     *
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        /** @var Product $product */
        $product = Product::query()->create($request->all());

        $this->storeGallery($request, $product);

        if ($request->filled('meta')) {
            $product->meta()->create($request->get('meta'));
        }

        $product->characteristics()->attach($request->get('attribute'));
        $product->series()->attach($request->get('series'));

        return redirect()->route('admin.product.index');
    }

    /**
     * Show the form for editing the product.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        return \view('admin.product.edit', [
            'product' => $product,
            'tags' => Product::$TAGS,
            'types' => CharacteristicType::all(),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'meta' => $product->meta()->first(),
            'series' => json_encode(SeriesResource::collection($product->series)),
        ]);
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->all());

        $this->storeGallery($request, $product);

        if ($request->filled('meta')) {
            $product->meta()->updateOrCreate([], $request->get('meta'));
        }

        $product->characteristics()->sync($request->get('attribute'));
        $product->series()->sync($request->get('series'));

        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->characteristics()->detach();
        $product->meta()->delete();
        $product->checkouts()->delete();

        $product->delete();

        return redirect()->route('admin.product.index');
    }

    /**
     * @return View
     */
    public function meta(): View
    {
        return \view('admin.product.meta', [
            'meta' => Meta::whereMetableId(0)->whereMetableType(Product::class)->first(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function metaStore(Request $request): RedirectResponse
    {
        Meta::query()->updateOrCreate([
            'metable_id' => 0,
            'metable_type' => Product::class,
        ], array_merge([
            'metable_id' => 0,
            'metable_type' => Product::class,
        ], $request->get('meta')));

        return \redirect()->route('admin.product.index');
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     */
    private function storeGallery(ProductRequest $request, Product $product): void
    {
        if ($request->filled('gallery')) {
            collect($request->get('gallery'))->map(function ($image) use ($product) {
                $item = json_decode($image);

                $product->addMediaFromBase64($item->url)
                        ->usingFileName($item->name)
                        ->toMediaCollection('product');
            });
        }
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return bool
     */
    private function compareTitle(ProductRequest $request, Product $product): bool
    {
        return $product->slug !== str_slug($request->get('title'));
    }
}
