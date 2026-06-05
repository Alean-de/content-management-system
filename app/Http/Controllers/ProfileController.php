<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('administrator.profileAdm');
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255']
        ]);

        auth()->user()->update([
            'name' => $request->name
        ]); 

        return back()->with(
            'success',
            'Nama berhasil diubah'
        );
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        if (!Hash::check(
            $request->current_password,
            auth()->user()->password
        )) {

            return back()->withErrors([
                'current_password' => 'Password lama salah'
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with(
            'success',
            'Password berhasil diubah'
        );
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()]
        ]);
        
        auth()->user()->update([
            'email' => $request->email
        ]);
        
        return back()->with(
            'success',
            'Email berhasil diubah'
        );

    }
}
