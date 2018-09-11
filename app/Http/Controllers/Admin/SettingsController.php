<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return \view('admin.settings.index', [
            'settings' => Setting::query()->get()->groupBy('type'),
        ]);
    }

    public function update(Request $request, Setting $setting): RedirectResponse
    {
        $setting->update($request->only('name', 'value'));

        return \back();
    }
}
