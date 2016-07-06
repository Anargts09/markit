<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tag;
use Auth, Response, Input;

class TagController extends Controller
{

    protected $tag;

    public function __construct(Tag $tag){
        $this->tag = $tag;
    }

    public function showTag($slug){   
        $tag = Tag::findBySlug($slug); 
        $posts = $tag->posts;
        $users = $tag->users;
        $followers = $tag->followusers;
        if(Auth::user()){
            $user   = Auth::user();
        }
        return view('tag.view')
                ->with(compact('user'))
                ->with(compact('tag'))
                ->with(compact('users'))
                ->with(compact('posts'))
                ->with(compact('followers'));
    }
    public function showAll(Request $request) {
        $term = strtolower(Input::get('term'));
        $limit      = 5;
        $tags = Tag::where('name','like','%'.$term.'%')->paginate($limit);
        foreach ($tags as $k => $tag) {
            if (strpos(strtolower($tag->name), $term) !== FALSE) {
                $result[] = array('value' => $tag->name, 'id' =>$k);
            }
        }
        if (empty($result)) {
            $result[] = array('value' => '', 'id' =>'0');
        }
        return Response::json($result);
    }
    public function listAll(){
        $tags = Tag::orderBy('post_count', 'desc')->paginate('24');
        $active ='alltag';
        if(Auth::user()){
            $user = Auth::user(); 
        }
        return view('tag.list')
            ->with('tags',$tags)
            ->with(compact('active'))
            ->with(compact('user'));
    }
}
