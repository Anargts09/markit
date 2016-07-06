<?php

namespace App\Http\Controllers\Auth;


use \Mail;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use View, Input, Auth;

use App\User;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getPasswordReset(){
        return view('user.forgotpassword');
    }
    public function postPasswordReset(){
        $email = Input::get('email');
        $userCheck = User::where('email', '=', $email)->first();
        if(!empty($userCheck)){
            $token          =   Input::get('_token');

            Mail::send('emails.password', ['token' => $token], function ($m) use ($userCheck) {
                $m->to($userCheck->email, $userCheck->username)->subject('Reset Password!');
            });

            return redirect()->route('auth.password')
                            ->with('status', 'success')
                            ->with('message', 'Имэйлээ шалгана уу.');

        }else{
            return redirect()->route('auth.password')
                            ->with('status', 'alert')
                            ->with('message', 'Манай системд бүртгэлгүй имэйл хаяг байна.')
                            ->withInput();
        }
    }
    public function getPasswordResetForm($token){
        return view('user.reset')
            ->with(compact('token'));
    }
}
