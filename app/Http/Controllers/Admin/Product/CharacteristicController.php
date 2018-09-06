<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Characteristic;
use App\Models\Product\CharacteristicType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CharacteristicController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $characteristics = Characteristic::query();

        if ($request->filled('search')) {
            $characteristics
                ->where('id', $request->get('search'))
                ->orWhere('title', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->filled('category')) {
            $characteristics->where('type_id', '=', $request->get('category'));
        }

        return \view('admin.product.attribute.index', [
            'characteristics' => $characteristics->latest('id')->paginate(20),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.product.attribute.create', [
            'types' => CharacteristicType::query()->get(),
            'selectors' => json_encode(Characteristic::$TYPES),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        Characteristic::query()->create($request->only('type', 'value', 'type_id'));

        return redirect()->route('admin.product.attribute.index');
    }

    /**
     * @param Characteristic $characteristic
     * @return View
     */
    public function edit(Characteristic $characteristic): View
    {
        return \view('admin.product.attribute.edit', [
            'characteristic' => $characteristic,
            'types' => CharacteristicType::query()->get(),
            'selectors' => json_encode(Characteristic::$TYPES),
        ]);
    }

    /**
     * @param Request $request
     * @param Characteristic $characteristic
     * @return RedirectResponse
     */
    public function update(Request $request, Characteristic $characteristic)
    {
        $characteristic->update($request->only('type', 'value', 'type_id'));

        return redirect()->route('admin.product.attribute.index');
    }

    /**
     * @param Characteristic $characteristic
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Characteristic $characteristic)
    {
        $characteristic->delete();

        return redirect()->route('admin.product.attribute.index');
    }
}
