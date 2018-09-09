<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Review\Review;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
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

    /**
     * @param CommentRequest $request
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(CommentRequest $request, Review $review)
    {
        if (!Auth::check()) {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt('secret'),
                'role_id' => 2,
            ]);
        } else {
            /** @var User $user */
            $user = Auth::user();
        }

        $review->comments()->create([
            'message' => $request->get('message'),
            'user_id' => $user->id,
        ]);

        \session()->flash('success', 'Комментарий успешно отправлен на модерацию.');

        return \back();
    }
}
