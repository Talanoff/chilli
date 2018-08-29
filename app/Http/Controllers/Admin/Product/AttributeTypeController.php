<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\AttributeType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttributeTypeController extends Controller
{
    public function index(): View
    {
        return \view('admin.product.type.index', [
            'types' => AttributeType::query()->get(),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.product.type.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        AttributeType::query()->create([
            'slug' => str_slug($request->get('title'), '-'),
            'title' => $request->get('title'),
        ]);

        return redirect()->route('admin.product.type.index');
    }

    /**
     * @param AttributeType $type
     * @return View
     */
    public function edit(AttributeType $type): View
    {
        return \view('admin.product.type.edit', compact('type'));
    }

    /**
     * @param Request $request
     * @param AttributeType $type
     * @return RedirectResponse
     */
    public function update(Request $request, AttributeType $type): RedirectResponse
    {
        $type->update([
            'slug' => str_slug($request->get('title'), '-'),
            'title' => $request->get('title'),
        ]);

        return redirect()->route('admin.product.type.index');
    }

    /**
     * @param AttributeType $type
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(AttributeType $type): RedirectResponse
    {
        $type->delete();

        return redirect()->route('admin.product.type.index');
    }
}
