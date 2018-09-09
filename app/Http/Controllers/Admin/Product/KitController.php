<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\KitResource;
use App\Http\Resources\ProductResource;
use App\Models\Product\Kit;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KitController extends Controller
{
    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function list(Product $product): JsonResponse
    {
        $kits = $product->kits->pluck('related_id')->toArray();
        $available = Product::latest()
                            ->where('id', '!=', $product->id)
                            ->whereNotIn('id', $kits)->get();

        return \response()->json([
            'kits' => KitResource::collection($product->kits),
            'products' => ProductResource::collection($available),
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function add(Request $request, Product $product): JsonResponse
    {
        Kit::query()->create([
            'product_id' => $product->id,
            'related_id' => $request->get('related_id'),
            'amount' => $request->get('amount'),
        ]);

        return $this->list($product);
    }

    /**
     * @param Product $product
     * @param Kit $kit
     * @return JsonResponse
     * @throws \Exception
     */
    public function remove(Product $product, Kit $kit): JsonResponse
    {
        $kit->delete();

        return $this->list($product);
    }
}
