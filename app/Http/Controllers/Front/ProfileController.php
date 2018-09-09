<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        return \view('app.profile.index', [
            'user' => $user,
            'orders' => $user->orders()->get(),
        ]);
    }
}
