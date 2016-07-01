<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Tag;
use App\Post;
use App\Follower;
use App\TagFollow;
use App\Postsave;
use Auth, Response;

class FollowerController extends Controller {

    protected $user;

    public function __construct(User $user){
        $this->user = $user;
    }
    
    /**       
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
    */

    // Цаг шалгаж алдаа буцаах функц нэмэх.
    
    public function userFollow($id, Request $request){
        if($request->ajax()) {
            $user1 = Auth::user();
            $user2 = User::find($id);
            if ($user1 && $user2 && $user1!=$user2) {
                // User Follow
                if (!$user1->followCheck($id)) {
                    $user1->following()->save($user2);
                    $user1->increment('following_count');
                    $user1->save();
                    $user2->increment('followers_count');
                    $user2->save();
                    return Response::json(array('success'=>true, 'type'=>'follow'));
                }
                // User UnFollow
                if ($user1->followCheck($id)) {
                    $uid=$user1->id;
                    $follower = Follower::where(function($query) use ($uid,$id){
                                    $query  ->where('user_id',$uid)
                                            ->where('follow_id', $id);
                                });
                    $follower->delete();
                    $user1->decrement('following_count');
                    $user1->save();
                    $user2->decrement('followers_count');
                    $user2->save();
                    return Response::json(array('success'=>true, 'type'=>'unfollow'));
                }
            }
            // Error
            return Response::json(array('success'=>false));
        }
    }
    public function getFollowers($uid){
        $user=User::find($uid);
        $followers=$user->followers;

        if(Request::ajax()) {

            $view=View::make('users.followers')->with('user',$user)->with('followers',$followers);
            $html=$view->render();

            return Response::json(array('html'=>$html));
        }

        return View::make('users.followers')->with('user',$user)->with('followers',$followers);
    }
    public function getFollowing($uid){
        $user=User::find($uid);
        $following=$user->following;

        if(Request::ajax()) {

            $view=View::make('users.following')->with('user',$user)->with('following',$following);
            $html=$view->render();
            return Response::json(array('html'=>$html));
        }
        return View::make('users.following')->with('user',$user)->with('following',$following);
    }
    /**       
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
    */
    public function tagFollow($id, Request $request){
        if($request->ajax()) {
            $user = Auth::user();
            $tag = Tag::find($id);
            if ($user && $tag && !$user->tagFollowCheck($id)) {
                $user->followtags()->save($tag);
                $tag->increment('follower_count');
                $tag->save();
                return Response::json(array('success'=>true));
            }
            return Response::json(array('success'=>false));
        }
    }
    /**       
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
    */
    public function tagUnfollow($id, Request $request){
        if($request->ajax()) {
            $user = Auth::user();
            $tag = Tag::find($id);
            if ($user && $tag && $user->tagFollowCheck($id)) {
                $uid=$user->id;
                TagFollow::where(function($query) use ($uid,$id){
                    $query  ->where('user_id',$uid)
                            ->where('tag_id', $id);
                })->delete();
                $tag->decrement('follower_count');
                $tag->save();
                return Response::json(array('success'=>true));
            }
            return Response::json(array('success'=>false));
        }
    }

    /**       
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
    */
    public function postSave($id, Request $request){
        if($request->ajax()) {
            $user = Auth::user();
            $post = Post::find($id);

            if ($user && $post && !$user->postSaveCheck($id)) {
                $user->savedposts()->save($post);
                $user->increment('saveitem_count'); 
                $post->increment('save_count');
                $post->save();
                return Response::json(array('success'=>true));
            }
            return Response::json(array('success'=>false));
        }
    }

    /**       
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
    */
    public function postUnsave($id, Request $request){
        if($request->ajax()) {
            $user = Auth::user();
            $post = Post::find($id);
            if ($user && $post && $user->postSaveCheck($id)) {
                $uid=$user->id;
                Postsave::where(function($query) use ($uid,$id){
                    $query  ->where('user_id',$uid)
                            ->where('post_id', $id);
                })->delete();
                $user->decrement('saveitem_count');
                $post->decrement('save_count');
                $post->save();
                return Response::json(array('success'=>true));
            }
            return Response::json(array('success'=>false));
        }
    }
}
