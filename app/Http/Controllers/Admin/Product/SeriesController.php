<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product\Brand;
use App\Models\Product\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $series = Series::with('brand');

        if ($request->filled('brand')) {
            $series = $series->where('brand_id', $request->get('brand'));
        }

        return \view('admin.product.series.index', [
            'series' => $series->paginate(40)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function list($id)
    {
        return \response()->json(Series::where('brand_id', $id)->get(['id', 'title']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return \view('admin.product.series.create', [
            'brands' => Brand::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $series = Series::create($request->only('title', 'brand_id'));

        return \redirect()->route('admin.product.series.edit', $series)
            ->with('success', 'Модель успешно добавлена.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Series $series
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Series $series)
    {
        return \view('admin.product.series.edit', [
            'brands' => Brand::get(),
            'series' => $series
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Series $series
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Series $series)
    {
        $series->update($request->only('title', 'brand_id'));

        return \redirect()->route('admin.product.series.edit', $series)
                          ->with('success', 'Модель успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Series $series
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Series $series)
    {
        $series->delete();

        return \redirect()->route('admin.product.series.index');
    }
}
