<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.notification.index', [
            'notifications' => Notification::latest()->paginate(50)
        ]);
    }

    /**
     * @param Request $request
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function changeStatus(Request $request, Notification $notification): RedirectResponse
    {
        $notification->update($request->only('status'));

        return \back();
    }
}
