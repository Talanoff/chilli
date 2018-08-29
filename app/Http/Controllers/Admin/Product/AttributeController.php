<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Attribute;
use App\Models\Product\AttributeType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttributeController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $attributes = Attribute::query();

        if ($request->filled('search')) {
            $attributes
                ->where('id', $request->get('search'))
                ->orWhere('title', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->filled('category')) {
            $attributes->where('type_id', '=', $request->get('category'));
        }

        return \view('admin.product.attribute.index', [
            'attributes' => $attributes->latest('id')->paginate(20),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.product.attribute.create', [
            'types' => AttributeType::query()->get(),
            'selectors' => json_encode(Attribute::$TYPES)
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        Attribute::query()->create($request->only('type', 'value', 'type_id'));

        return redirect()->route('admin.product.attribute.index');
    }

    /**
     * @param Attribute $attribute
     * @return View
     */
    public function edit(Attribute $attribute): View
    {
        return \view('admin.product.attribute.edit', [
            'attribute' => $attribute,
            'types' => AttributeType::query()->get(),
            'selectors' => json_encode(Attribute::$TYPES)
        ]);
    }

    /**
     * @param Request $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function update(Request $request, Attribute $attribute)
    {
        $attribute->update($request->only('type', 'value', 'type_id'));

        return redirect()->route('admin.product.attribute.index');
    }

    /**
     * @param Attribute $attribute
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('admin.product.attribute.index');
    }
}
