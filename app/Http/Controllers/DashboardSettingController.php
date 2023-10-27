<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\SettingRequest;

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
        $provinces = Province::all();
        $user = Auth::user();
        return view('pages.dahsboard-account', compact('user', 'provinces'));
    }

    public function update(Request $request, $redirect)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => [
                'required', 'string', 'max:254',
            ],
            'password' => [
                'required', 'string', 'min:8', 'confirmed',
            ],
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore(Auth::user()->id),
            ],
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()->back()->withErrors($messages);
        }

        // cek ada update password atau tidak
        if ($request->password != null) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = Auth::user()->password;
        }

        $item = Auth::user();

        $item->update($data);

        return redirect()->route($redirect);
    }
}
