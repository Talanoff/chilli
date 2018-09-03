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
        $Characteristics = Characteristic::query();

        if ($request->filled('search')) {
            $Characteristics
                ->where('id', $request->get('search'))
                ->orWhere('title', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->filled('category')) {
            $Characteristics->where('type_id', '=', $request->get('category'));
        }

        return \view('admin.product.Characteristic.index', [
            'Characteristics' => $Characteristics->latest('id')->paginate(20),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.product.Characteristic.create', [
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

        return redirect()->route('admin.product.Characteristic.index');
    }

    /**
     * @param Characteristic $Characteristic
     * @return View
     */
    public function edit(Characteristic $Characteristic): View
    {
        return \view('admin.product.Characteristic.edit', [
            'Characteristic' => $Characteristic,
            'types' => CharacteristicType::query()->get(),
            'selectors' => json_encode(Characteristic::$TYPES),
        ]);
    }

    /**
     * @param Request $request
     * @param Characteristic $Characteristic
     * @return RedirectResponse
     */
    public function update(Request $request, Characteristic $Characteristic)
    {
        $Characteristic->update($request->only('type', 'value', 'type_id'));

        return redirect()->route('admin.product.Characteristic.index');
    }

    /**
     * @param Characteristic $Characteristic
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Characteristic $Characteristic)
    {
        $Characteristic->delete();

        return redirect()->route('admin.product.Characteristic.index');
    }
}
