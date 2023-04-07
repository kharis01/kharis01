<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function editpassword()
    {
        return view('admin.profile.change-password');
    }

    public function updatepassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|string',
            'password' => 'required|min:6|string',
            'confirmation_password' => 'required|min:6|string'
        ]);

        $currentpassword = Hash::check($request->current_password, auth()->user()->password);
        if ($currentpassword) {
            # code...
            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->back()->with([Alert::success('Success', 'Password berhasil diupdate')]);
        } else {
            return redirect()->back()->with([Alert::error('Error', 'Password Salah')]);
        }

    }
}
