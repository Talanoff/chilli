<?php

namespace App\Http\Controllers\Admin;

use App\Models\User\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.user.index', [
            'users' => User::latest()->withTrashed()->paginate(20),
        ]);
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return \view('admin.user.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($request->all());
        return \back();
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::user()->id) {
            return \back();
        }

        $user->comments()->delete();
        $user->delete();

        return redirect()->route('admin.user.index');
    }
}
