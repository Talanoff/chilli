<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    /**
     * @param Media $media
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Media $media): JsonResponse
    {
        try {
            $media->delete();
        } catch (\ErrorException) {}

        return response()->json([]);
    }
}
