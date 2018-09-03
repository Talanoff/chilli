<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
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
        $media->delete();

        return response()->json([]);
    }
}
