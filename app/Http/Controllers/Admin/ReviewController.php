<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        return \view('admin.review.index', [
            'reviews' => Review::query()->latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return \view('admin.review.create');
    }

    public function store(ReviewRequest $request): RedirectResponse
    {
        Review::query()->create(array_merge([
            'slug' => str_slug($request->get('title')),
        ], $this->handleReviewParams($request)));

        return redirect()->route('admin.review.index');
    }

    public function edit(Review $review): View
    {
        return \view('admin.review.edit', compact('review'));
    }

    public function update(ReviewRequest $request, Review $review): RedirectResponse
    {
        $review->update($this->handleReviewParams($request));

        if ($this->compareTitle($request, $review)) {
            $review->update([
                'slug' => str_slug($request->get('title')),
            ]);
        }

        return redirect()->route('admin.review.index');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.review.index');
    }

    /**
     * @param ReviewRequest $request
     * @return array
     */
    private function handleReviewParams(ReviewRequest $request): array
    {
        return $request->only('title', 'description', 'video_url', 'product_id', 'is_published');
    }

    /**
     * @param ReviewRequest $request
     * @param Review $review
     * @return bool
     */
    private function compareTitle(ReviewRequest $request, Review $review): bool
    {
        return $review->slug !== str_slug($request->get('title'));
    }
}
