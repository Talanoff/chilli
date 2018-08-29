<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(): View
    {
        return \view('admin.comment.index', [
            'comments' => Comment::query()
                ->orderByRaw("FIELD(status , 'agreement') DESC")
                ->orderByRaw("FIELD(status , 'approved') DESC")
                ->latest()
                ->paginate(20)
        ]);
    }
}
