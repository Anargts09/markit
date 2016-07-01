<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator, Session, Auth, App;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProfile($slug){   
        $showuser = User::findBySlug($slug);
        $myprofile = false;
        if(Auth::user()){
            $user   = Auth::user();
            if($showuser->id == $user->id){
                $myprofile = true;
            }
        }
        $followings = $showuser->followingSix; 
        $followers = $showuser->followerSix; 
        $followtags = $showuser->followtagsFive;
        $posts = $showuser->posts;
        return view('user.profile')
                ->with(compact('myprofile'))
                ->with(compact('showuser'))
                ->with(compact('user'))
                ->with(compact('posts'))
                ->with(compact('followings'))
                ->with(compact('followtags'))
                ->with(compact('followers'));
    }

    public function getEditProfile(){
        $user   = Auth::user();
        $open   = $user->email_open;
        $active = 'profile';

        return view('user.settings')
                ->with(compact('open'))
                ->with(compact('active'))
                ->with(compact('user'));
    }
    
    public function getEditAccount(){
        $user   = Auth::user();
        $active = 'account';

        return view('user.account')
                ->with(compact('active'))
                ->with(compact('user'));
    }

    public function postEditProfile(Request $request){
        $rules = array(
            'webblog'   => 'url',
            'bio'       => 'max:300'
        );
        $messages = [
            'webblog.url' => 'Website/Blog Url буруу байна.',
            'bio.max' => 'Товч танилцуулгаа 300 үсгэнд багтаана уу.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('user.get-editprofile')
                -> withErrors($validator)
                -> with('status', 'alert')
                -> withInput();
        } else {

            $user = Auth::user();
            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->webblog    = $request->webblog;
            $user->company    = $request->company;
            $user->bio        = $request->bio;
            $user->save();

            Session::flash('message', 'Амжилттай хадгалагдлаа!');
            return redirect()->route('user.get-editprofile')
                                ->with('status', 'success');
        }
    }

    public function postEditAccount(Request $request){
        $user = Auth::user();
        if (empty($user->provider)) {
            if($request->avatar_type == '1'){
                return redirect()->route('user.get-editaccount')
                    -> with('status', 'alert')
                    -> withInput();
            }
        }
        $user->avatar_type      = $request->avatar_type;
        $user->username         = $request->username;
        $user->user_language    = $request->user_language;
        $user->save();

        Session::put('locale', $user->user_language);

        Session::flash('message', 'Амжилттай хадгалагдлаа!');
        return redirect()->route('user.get-editaccount')
                        ->with('status', 'success');
    }

    public function listAll(){
        $users = User::orderBy('followers_count', 'desc')->paginate('24');
        if(Auth::user()){
            $user = Auth::user(); 
        }
        return view('user.alluser')
            ->with('users',$users)
            ->with(compact('user'));
    }

    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFollowers($slug){   
        $showuser = User::findBySlug($slug);
        $myprofile = false;
        $active ='followers';
        if(Auth::user()){
            $user   = Auth::user();
            if($showuser->id == $user->id){
                $myprofile = true;
            }
        }
        $users = $showuser->followers;
        return view('user.followusers')
                ->with(compact('myprofile'))
                ->with(compact('user'))
                ->with(compact('showuser'))
                ->with(compact('users'))
                ->with(compact('active'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFollowing($slug){   
        $showuser = User::findBySlug($slug);
        $myprofile = false;
        $active ='following';
        if(Auth::user()){
            $user   = Auth::user();
            if($showuser->id == $user->id){
                $myprofile = true;
            }
        }
        $users = $showuser->following;
        return view('user.followusers')
                ->with(compact('myprofile'))
                ->with(compact('user'))
                ->with(compact('showuser'))
                ->with(compact('users'))
                ->with(compact('active'));
    }


}
