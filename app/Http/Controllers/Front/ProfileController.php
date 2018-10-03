<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserProfileRequest;
use App\Models\User\User;
use Illuminate\Http\RedirectResponse;
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
            'orders' => $user->orders()->latest()->paginate(10),
        ]);
    }

    /**
     * @return View
     */
    public function edit(): View
    {
        return \view('app.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * @param EditUserProfileRequest $request
     * @return RedirectResponse
     */
    public function update(EditUserProfileRequest $request): RedirectResponse
    {
        Auth::user()->update([
            'name' => $request->get('name'),
            'phone' => str_replace([' ', '(', ')', '-'], '', $request->get('phone')),
            'birthday' => $request->get('birthday'),
        ]);

        return \redirect()->route('app.profile.index');
    }

    /**
     * Logout and redirect to reset password form
     * @return RedirectResponse
     */
    public function passwordReset(): RedirectResponse
    {
        Auth::guard()->logout();

        request()->session()->invalidate();

        return \redirect()->route('password.request');
    }
}
