<?php

namespace App\Http\Controllers\Admin;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.user.index', [
            'users' => User::query()->latest()->paginate(20)
        ]);
    }
}
