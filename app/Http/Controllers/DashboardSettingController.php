<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\SettingRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSettingController extends Controller
{
    public function store()
    {
        $user = Auth::user();
        $categories = Category::all();
        return view('pages.dahsboard-settings', compact('user', 'categories'));
    }

    public function account()
    {
        $user = Auth::user();
        return view('pages.dahsboard-account', compact('user'));
    }

    public function update(SettingRequest $request, $redirect)
    {
        $data = $request->all();
        $item = Auth::user();

        $item->update($data);

        return redirect()->route($redirect);
    }
}
