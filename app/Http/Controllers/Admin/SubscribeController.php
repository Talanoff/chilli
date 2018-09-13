<?php

namespace App\Http\Controllers\Admin;

use App\Models\User\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SubscribeController extends Controller
{
    public function index(): View
    {
        return \view('admin.subscribe.index', [
            'subscribes' => Subscribe::query()
                                     ->get()
                                     ->pluck('email')
                                     ->chunk(40)
                                     ->toArray(),
        ]);
    }
}
