<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.comment.index', [
            'comments' => Comment::query()
                                 ->orderByRaw("FIELD(status , 'agreement') DESC")
                                 ->orderByRaw("FIELD(status , 'approved') DESC")
                                 ->latest()->paginate(20)
        ]);
    }

    /**
     * @param Comment $comment
     * @return View
     */
    public function edit(Comment $comment): View
    {
        return \view('admin.comment.edit', compact('comment'));
    }

    /**
     * @param Request $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $comment->update($request->only('status'));

        return redirect()->route('admin.comment.index');
    }

    /**
     * @param Comment $comment
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('admin.comment.index');
    }
}
