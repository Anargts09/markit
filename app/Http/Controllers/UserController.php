<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\Converter;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Tag;
use Validator, Session, Auth, App;

class UserController extends Controller
{
    protected $converter;

    public function __construct(Converter $converter){
        $this->converter = $converter;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProfile($slug){   
        $showuser = User::findBySlug($slug);
        $myprofile = false;
        $active ='posted';
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
                ->with(compact('followers'))
                ->with(compact('active'));
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

    public function getEditSkill(){
        $user   = Auth::user();
        $active = 'skill';

        return view('user.skill')
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
        $active ='alluser';
        if(Auth::user()){
            $user = Auth::user(); 
        }
        return view('user.alluser')
            ->with('users',$users)
            ->with(compact('active'))
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
        $followings = $showuser->followingSix; 
        $followers = $showuser->followerSix; 
        $followtags = $showuser->followtagsFive;
        if(Auth::user()){
            $user   = Auth::user();
            if($showuser->id == $user->id){
                $myprofile = true;
            }
        }
        $users = $showuser->followers()->paginate(12);
        return view('user.followusers')
                ->with(compact('myprofile'))
                ->with(compact('user'))
                ->with(compact('showuser'))
                ->with(compact('users'))
                ->with(compact('active'))
                ->with(compact('followings'))
                ->with(compact('followtags'))
                ->with(compact('followers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFollowing($slug){   
        $showuser = User::findBySlug($slug);
        $myprofile = false;
        $followings = $showuser->followingSix; 
        $followers = $showuser->followerSix; 
        $followtags = $showuser->followtagsFive;
        $active ='following';
        if(Auth::user()){
            $user   = Auth::user();
            if($showuser->id == $user->id){
                $myprofile = true;
            }
        }
        $users = $showuser->following()->paginate(12);
        return view('user.followusers')
                ->with(compact('myprofile'))
                ->with(compact('user'))
                ->with(compact('showuser'))
                ->with(compact('users'))
                ->with(compact('active'))
                ->with(compact('followings'))
                ->with(compact('followtags'))
                ->with(compact('followers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFollowTags($slug){   
        $showuser = User::findBySlug($slug);
        $myprofile = false;
        $followings = $showuser->followingSix; 
        $followers = $showuser->followerSix; 
        $followtags = $showuser->followtagsFive;
        $active ='Followed tags';
        if(Auth::user()){
            $user   = Auth::user();
            if($showuser->id == $user->id){
                $myprofile = true;
            }
        }
        $tags = $showuser->followtags()->paginate(12);
        return view('user.followtags')
                ->with(compact('myprofile'))
                ->with(compact('user'))
                ->with(compact('showuser'))
                ->with(compact('tags'))
                ->with(compact('active'))
                ->with(compact('followings'))
                ->with(compact('followtags'))
                ->with(compact('followers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSavedItems($slug){
        $showuser = User::findBySlug($slug);
        $myprofile = false;
        $followings = $showuser->followingSix; 
        $followers = $showuser->followerSix; 
        $followtags = $showuser->followtagsFive;

        $active ='saved';
        if(Auth::user()){
            $user   = Auth::user();
            if($showuser->id == $user->id){
                $myprofile = true;
            }
        }
        $savedposts = $showuser->savedposts;
        return view('user.saveditems')
                ->with(compact('myprofile'))
                ->with(compact('user'))
                ->with(compact('showuser'))
                ->with(compact('savedposts'))
                ->with(compact('active'))
                ->with(compact('followings'))
                ->with(compact('followtags'))
                ->with(compact('followers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDraftItems(){
        $user   = Auth::user();
        $showuser = $user;
        $myprofile = true;

        $followings = $showuser->followingSix; 
        $followers = $showuser->followerSix; 
        $followtags = $showuser->followtagsFive;
        $active ='drafts';
        $draftposts = $user->drafts;
        return view('user.draftitems')
                ->with(compact('myprofile'))
                ->with(compact('user'))
                ->with(compact('showuser'))
                ->with(compact('draftposts'))
                ->with(compact('active'))
                ->with(compact('followings'))
                ->with(compact('followtags'))
                ->with(compact('followers'));
    }

    public function showCommentItems($slug){
        $showuser = User::findBySlug($slug);
        $myprofile = false;
        $followings = $showuser->followingSix; 
        $followers = $showuser->followerSix; 
        $followtags = $showuser->followtagsFive;
        $active ='comment';
        $result = array();
        $comments = $showuser->comments;

        foreach ($comments as $k => $comment) {
            $markdown = $this->converter->convertToHtml(html_entity_decode($comment->body));
            $result[$k] = $markdown;
        }

        if(Auth::user()){
            $user   = Auth::user();
            if($showuser->id == $user->id){
                $myprofile = true;
            }
        }
        return view('user.commentitems')
                ->with(compact('myprofile'))
                ->with(compact('user'))
                ->with(compact('showuser'))
                ->with(compact('comments'))
                ->with(compact('active'))
                ->with(compact('followings'))
                ->with(compact('followtags'))
                ->with(compact('followers'))
                ->with(compact('result'));
    }

    public function postAddSkill(Request $request){
        $user = Auth::user();
        $split_tags = explode(',' , $request->tags);
        foreach ($split_tags as $tag) {
            $tagCheck = Tag::where('name', '=', $tag)->first();
            if((empty($tagCheck))&&(!empty($tag))){
                $newTag                     = new Tag;
                $newTag->name                = $tag;
                $newTag->tag_image          = '/tag_image/default.png';
                $newTag->save();
                $tag = $newTag;
            }else{
                $tag = $tagCheck;
            }
            $tag->increment('user_count'); 
            $tagList[] = $tag->id;
        }
        $user->tags()->sync($tagList);
    }


}
