<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.review.index', [
            'reviews' => Review::query()->latest()->paginate(20),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.review.create');
    }

    /**
     * @param ReviewRequest $request
     * @return RedirectResponse
     */
    public function store(ReviewRequest $request): RedirectResponse
    {
        /** @var Review $review */
        $review = Review::query()->create(array_merge([
            'slug' => str_slug($request->get('title')),
        ], $this->handleReviewParams($request)));

        if ($request->hasFile('image')) {
            $review->addMediaFromRequest('image')
                ->toMediaCollection('review');
        }

        return redirect()->route('admin.review.index');
    }

    /**
     * @param Review $review
     * @return View
     */
    public function edit(Review $review): View
    {
        return \view('admin.review.edit', compact('review'));
    }

    /**
     * @param ReviewRequest $request
     * @param Review $review
     * @return RedirectResponse
     */
    public function update(ReviewRequest $request, Review $review): RedirectResponse
    {
        $review->update($this->handleReviewParams($request));

        if ($this->compareTitle($request, $review)) {
            $review->update([
                'slug' => str_slug($request->get('title')),
            ]);
        }

        if ($request->hasFile('image')) {
            $review->clearMediaCollection('review');

            $review->addMediaFromRequest('image')
                   ->toMediaCollection('review');
        }

        return redirect()->route('admin.review.index');
    }

    /**
     * @param Review $review
     * @return RedirectResponse
     * @throws \Exception
     */
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
        return $request->only('title', 'description', 'video_url', 'product_id', 'is_published', 'type');
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
