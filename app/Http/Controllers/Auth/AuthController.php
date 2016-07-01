<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator, Input, Hash, DateTime, Auth, Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $auth;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogout(){

        $this->auth->logout();
        Session::put('locale', 'en');
        Session::flash('message', 'Амжилттай гарлаа.');
        return redirect()->route('index')
            -> with('status', 'success');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    /**
     *
     * @return Response
     */
    public function getSocialRedirect( $provider ){
        $providerKey = \Config::get('services.' . $provider);
        if(empty($providerKey))
            return view('pages.status')
                    ->with('error', 'No such provider');

        return Socialite::driver( $provider )->redirect();
    }

    /**
     *
     * @return Response
     */
    public function getSocialHandle( $provider ){

        $user = Socialite::driver( $provider )->user();

        $socialUser = null;

        if($provider == 'github'){
            $userCheck = User::where('provider_id', '=', $user->id)->first();
        }else{
            $userCheck = User::where('provider_id', '=', $user->token)->first();
        }

        if(!empty($userCheck)){
            $socialUser = $userCheck;
            $socialUser->avatar = $user->avatar;
            $socialUser->save();
        }else{
            $newSocialUser                      = new User;
            $newSocialUser->email               =   $user->email;
            if($provider == 'twitter'){
                $newSocialUser->provider_id         =   $user->token;
                $name = explode(' ', $user->name);
                $name = $name[0];
            }else{
                $newSocialUser->provider_id         =   $user->id;
                $name = $user->getNickname();
            }
            $newSocialUser->username            =   $name;
            $newSocialUser->avatar              =   $user->avatar;
            $newSocialUser->provider            =   $provider;
            $newSocialUser->avatar_type         =   '1';
            $newSocialUser->avatar1             = '/user_image/default.png';
            $newSocialUser->save();
            $socialUser = $newSocialUser;
        }

        $socialUser->last_login = new DateTime();
        $socialUser->save();


        $this->auth->login($socialUser, true);

        Session::put('locale', $socialUser->user_language);


        return "<script>window.opener.location.reload();window.close();</script>";
        
        return redirect()->route('index');

        return \App::abort(500);
    }
}
