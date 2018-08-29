<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $categories = Category::query();

        if ($request->filled('search')) {
            $categories
                ->where('id', $request->get('search'))
                ->orWhere('title', 'like', '%' . $request->get('search') . '%');
        }

        return \view('admin.product.category.index', [
            'categories' => $categories->latest('id')->paginate(20),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.product.category.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        Category::query()->create([
            'slug' => str_slug($request->get('title'), '-'),
            'title' => $request->get('title'),
        ]);

        return redirect()->route('admin.product.category.index');
    }

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return \view('admin.product.category.edit', compact('category'));
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update([
            'slug' => str_slug($request->get('title'), '-'),
            'title' => $request->get('title'),
        ]);

        return redirect()->route('admin.product.category.index');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.product.category.index');
    }
}
