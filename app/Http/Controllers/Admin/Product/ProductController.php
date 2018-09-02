<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product\AttributeType;
use App\Models\Product\Category;
use App\Models\Product\Product;
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
        $products = Product::query()->with('comments', 'ratings', 'category');

        if ($request->filled('search')) {
            $products
                ->where('id', ltrim($request->get('search'), '0'))
                ->orWhere('title', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->filled('category')) {
            $products->where('category_id', '=', $request->get('category'));
        }

        return \view('admin.product.index', [
            'products' => $products->latest('id')->paginate(20),
        ]);
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
            'types' => AttributeType::query()->with('attribute')->get(),
            'categories' => Category::query()->latest('id')->get(),
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
        $product = Product::query()->create(array_merge([
            'slug' => str_slug($request->get('title')),
        ], $this->handleProductParams($request)));

        $this->storeGallery($request, $product);

        $product->attributes()->attach($request->get('attribute'));

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
            'types' => AttributeType::query()->with('attribute')->get(),
            'categories' => Category::query()->latest('id')->get(),
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
        $product->update($this->handleProductParams($request));

        if ($this->compareTitle($request, $product)) {
            $product->update([
                'slug' => str_slug($request->get('title')),
            ]);
        }

        $this->storeGallery($request, $product);

        $product->attributes()->sync($request->get('attribute'));

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
        $product->attributes()->detach();

        $product->delete();

        return redirect()->route('admin.product.index');
    }

    /**
     * @param ProductRequest $request
     * @return array
     */
    private function handleProductParams(ProductRequest $request): array
    {
        return $request->only(
            'title',
            'subtitle',
            'description',
            'price',
            'quantity',
            'discount',
            'in_stock',
            'category_id',
            'is_published',
            'rating',
            'tag'
        );
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
