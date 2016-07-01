<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, Response, View, App;

use App\Post;
use App\Comment;
use App\PostTag;
use App\Postsave;

class AjaxController extends Controller
{
    public function getAjaxPost() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        $view=View::make('ajax.posts')
            ->with('posts',$posts);
            
        if(Auth::user()){
            $user = Auth::user(); 
        }

        $html=$view->render();
        return Response::json(array('html'=>$html));
    }

    public function getAjaxComments($slug){
        $post = Post::findBySlug($slug);
        $comments  = Comment::where('post_id', '=', $post->id)->orderBy('created_at', 'desc')->paginate(5);

        $view=View::make('ajax.comments')
            ->with('comments',$comments);
        $html=$view->render();

        return Response::json(array('html'=>$html));
    }

    public function getAjaxFeed() {
         $user = Auth::user(); 
        // FEED POSTS
            $followtags = $user->followtags;
            $followusers = $user->following;
        // FOLLOWED TAGS ID
            $result = array();
            foreach ($followtags as $k => $tag) {
                $t  = $tag->id;
                $result[$k] = $t;
            }
        // FOLLOWED TAGS PIVOT POST
            $postByTag = PostTag::whereIn('tag_id', $result)->get();
            $result2 = array();
            foreach ($postByTag as $k => $pui) {
                $p  = $pui->post_id;
                $result2[$k] = $p;
            }
        // FOLLOWED USERS ID
            $result1 = array();
            foreach ($followusers as $k => $fui) {
                $u  = $fui->id;
                $result1[$k] = $u;
            }
        // FOLLOWED USERS SAVED POST ID
            $postBySave = Postsave::whereIn('user_id', $result1)->get();
            $result3 = array();
            foreach ($postBySave as $k => $pui) {
                $p  = $pui->post_id;
                $result3[$k] = $p;
            }
        // POST BY TAG
            $tagbypost  = Post::whereIn('id', $result2)->whereNotIn('user_id', [$user->id]);
        // POST BY FOLLOWED USER SAVE
            $savebypost  =Post::whereIn('id', $result3)->whereNotIn('user_id', [$user->id]);
        // MIX RESULTS
            $feedposts   = Post::whereIn('user_id', $result1)
                ->union($tagbypost)
                ->union($savebypost)
                ->orderBy('created_at', 'desc')
                ->simplePaginate(10);

        $feedcount  = count($feedposts);
         $view=View::make('ajax.feed')
            ->with('feedposts',$feedposts)
            ->with('user',$user)
            ->with('feedcount', $feedcount);
        $html=$view->render();
        return Response::json(array('html'=>$html));
    }
}
