<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    /**
     * Display the change password view.
     *
     */
    public function showChangePasswordForm()
    {
        return view('auth.passwords.change');
    }

    /**
     * Change current user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $updateData = $request->validate([
            'current-password' => ['required'],
            'new-password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $currentPassword = Auth::user()->password;
        if (Hash::check($updateData['current-password'], $currentPassword)) {
            $userId = Auth::user()->id;
            $user = User::find($userId);
            $user->password = Hash::make($updateData['new-password']);
            $user->save();
            return redirect('/home')->with('success', 'Password has been updated!');
        } else {
            return back()->withErrors('Contraseña incorrecta!');
        }
    }
}
