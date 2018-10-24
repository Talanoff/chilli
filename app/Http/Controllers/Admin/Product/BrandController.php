<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.product.brand.index', [
            'brands' => Brand::query()->paginate(20),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.product.brand.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var Brand $brand */
        $brand = Brand::query()->create($request->only('title'));

        if ($request->hasFile('image')) {
            $brand->addMediaFromRequest('image')
                  ->usingFileName($brand->slug
                                  . '.'
                                  . $request->file('image')->getClientOriginalExtension()
                  )
                  ->toMediaCollection('brand');
        }

        return \redirect()->route('admin.product.brand.index');
    }

    /**
     * @param Brand $brand
     * @return View
     */
    public function edit(Brand $brand): View
    {
        return \view('admin.product.brand.edit', compact('brand'));
    }

    /**
     * @param Request $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->only('title'));

        if ($request->hasFile('image')) {
            $brand->clearMediaCollection('brand');
            $brand->addMediaFromRequest('image')
                  ->usingFileName($brand->slug
                                  . '.'
                                  . $request->file('image')->getClientOriginalExtension()
                  )
                  ->toMediaCollection('brand');
        }

        return \redirect()->route('admin.product.brand.index');
    }

    /**
     * @param Brand $brand
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return \redirect()->route('admin.product.brand.index');
    }
}
