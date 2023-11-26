<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function reset(string $email, string $token)
    {
        return view('reset', compact('email', 'token'));
    }

    public function update(Request $request)
    {
        $this->validatePassword($request);
        $user = User::where('email', $request->input('email'))->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect('/')->with('status', 'Profile updated!');
    }

    private function validatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required | min:8 | confirmed',
            'password_confirmation' => 'required | min:8'
        ]);
    }
}