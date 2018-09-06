<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Review\Review;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        return \view('app.review.index', [
            'reviews' => Review::query()->latest()->paginate(12),
        ]);
    }

    public function show(Review $review): View
    {
        return \view('app.review.show', [
            'review' => $review,
        ]);
    }
}
