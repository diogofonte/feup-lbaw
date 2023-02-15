<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth; 


class ForgotPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:admin');
    }

    public function showForgetPasswordForm(){
        $user = Auth::user(); 
        if(is_null($user)){
            return view('auth.forgot-password',['order'=>null]);   
        }
        return view('auth.forgot-password',[ 'order' => $user->orders->where('status', 'Shopping Cart')->first()]);
    }

    public function submitForgetPasswordForm(Request $request){
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token){
        return view('auth.reset-password',['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
            
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('home')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function showForgetPasswordAdminForm(){
        return view('auth.forgot-password-admin');
    }

    public function submitForgetPasswordAdminForm(Request $request){
        $request->validate(['email' => 'required|email']);
        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordAdminForm($token){
        return view('auth.reset-password-admin', ['token' => $token]);

    }

    public function submitResetPasswordAdminForm(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
            
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('home')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}