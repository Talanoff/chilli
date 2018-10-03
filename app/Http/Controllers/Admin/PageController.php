<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.page.index', [
            'pages' => Page::latest()->paginate(10),
        ]);
    }

    /**
     * @param Page $page
     * @return View
     */
    public function edit(Page $page): View
    {
        return \view('admin.page.edit', compact('page'));
    }

    /**
     * @param Page $page
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Page $page, Request $request): RedirectResponse
    {
        $page->update($request->only('title', 'body', 'params'));

        if ($request->filled('meta')) {
            $page->meta()->updateOrCreate([], $request->get('meta'));
        }

        return \back();
    }
}
