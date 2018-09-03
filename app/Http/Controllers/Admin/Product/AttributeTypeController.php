<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\CharacteristicType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CharacteristicTypeController extends Controller
{
    public function index(): View
    {
        return \view('admin.product.type.index', [
            'types' => CharacteristicType::query()->get(),
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
        CharacteristicType::query()->create([
            'slug' => str_slug($request->get('title'), '-'),
            'title' => $request->get('title'),
        ]);

        return redirect()->route('admin.product.type.index');
    }

    /**
     * @param CharacteristicType $type
     * @return View
     */
    public function edit(CharacteristicType $type): View
    {
        return \view('admin.product.type.edit', compact('type'));
    }

    /**
     * @param Request $request
     * @param CharacteristicType $type
     * @return RedirectResponse
     */
    public function update(Request $request, CharacteristicType $type): RedirectResponse
    {
        $type->update([
            'slug' => str_slug($request->get('title'), '-'),
            'title' => $request->get('title'),
        ]);

        return redirect()->route('admin.product.type.index');
    }

    /**
     * @param CharacteristicType $type
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(CharacteristicType $type): RedirectResponse
    {
        $type->delete();

        return redirect()->route('admin.product.type.index');
    }
}
