<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\Converter;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\User;
use App\Postsave;

use Auth, Session, Validator;

class PostController extends Controller
{
    protected $post, $converter, $tag;

    public function __construct(Post $post, Converter $converter, Tag $tag, Postsave $postsave){
        $this->post = $post;
        $this->tag = $tag;
        $this->postsave = $postsave;
        $this->converter = $converter;
    }

    public function showPost($slug){   


        $post = Post::findBySlug($slug);
        $savedusers = $post->savedUsersEl;
        $tags = $post->tags;

        $markdown = $this->converter->convertToHtml(html_entity_decode($post->body));

        if(Auth::user()){
            $user   = Auth::user();
            $mypost = false;
            if($post->user_id == $user->id){
                $mypost = true;
            } 
        }else{
            $mypost = false;
        }
        return view('post.view')
                ->with(compact('post'))
                ->with(compact('markdown'))
                ->with(compact('user'))
                ->with(compact('mypost'))
                ->with(compact('tags'))
                ->with(compact('savedusers'));
    }

    public function showbyMd($slug){
        return '123';
    }

    public function getNew(){
        $user = Auth::user(); 
        $edit = false;
        return view('post.addnew')
            ->with(compact('edit'))
            ->with(compact('user'));
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postNew(Request $request){
        $rules = array(
            'title'         => 'required|max:400',
            'inputPane'     => 'required',
            'tags'          =>  'required',
        );
        $messages = [
            'title.required'        => 'Гарчиг хоосон байна.',
            'title.max'             => 'Гарчиг 400 үсгэнд багтаана уу.',
            'inputPane.required'    => 'Их бие хоосон байна',
            'tags.required'         => 'Дор хаяж нэг таг оруулна уу'
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('post.addnew')
                -> withErrors($validator)
                -> with('status', 'alert')
                -> withInput();
        } else {

            $user = Auth::user();

            $newPost                     = new Post;
            $newPost->title              = htmlentities($request->title);
            $newPost->body               = htmlentities($request->inputPane);
            $newPost->user_id            = $user->id;
            $newPost->save();
            $user->increment('item_count'); 
            if ($newPost->save()) {
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
                    $tag->increment('post_count'); 
                    $tagList[] = $tag->id;
                }
                $newPost->tags()->sync($tagList);
            }

            Session::flash('message', 'Амжилттай хадгалагдлаа!');
            return redirect()->route('post.showbySlug', array('slug' =>$newPost->slug))
                                ->with('status', 'success');
            return $request->all();
        }
    }

    public function editPost($slug){   
        $post = Post::findBySlug($slug);
        $user   = Auth::user();
        $edit = true;
        if($post->user_id != $user->id){
            return 'alert';
        } 
        return view('post.addnew')
                ->with(compact('edit'))
                ->with(compact('post'))
                ->with(compact('user'));
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postEditPost($slug, Request $request){

        $rules = array(
            'title'         => 'required|max:400',
            'inputPane'     => 'required',
            'tags'          =>  'required',
        );
        $messages = [
            'title.required'        => 'Гарчиг хоосон байна.',
            'title.max'             => 'Гарчиг 400 үсгэнд багтаана уу.',
            'inputPane.required'    => 'Их бие хоосон байна',
            'tags.required'         => 'Дор хаяж нэг таг оруулна уу'
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $post = Post::findBySlug($slug);
            return redirect()->route('post.editPost', $post->slug)
                -> withErrors($validator)
                -> with('status', 'alert')
                -> withInput();
        } else {

            $user = Auth::user();
            $post = Post::findBySlug($slug);

            $post->title              = htmlentities($request->title);
            $post->body            = htmlentities($request->inputPane);
            $post->status           =$request->status; 
            $post->save();
            if ($post->save()) {
                foreach( $post->tags as $oldtag){
                    $oldtag->decrement('post_count'); 
                }
                $split_tags = explode(',' , $request->tags);
                foreach ($split_tags as $tag) {
                    if(!empty($tag)){
                        $tagCheck = Tag::where('name', '=', $tag)->first();
                        if(empty($tagCheck)){
                            $newTag                     = new Tag;
                            $newTag->name                = $tag;
                            $newTag->tag_image          = '/tag_image/default.png';
                            $newTag->save();
                            $tag = $newTag;
                        }else{
                            $tag = $tagCheck;
                        }
                        $tag->increment('post_count'); 
                        $tagList[] = $tag->id;
                    }
                }
                $post->tags()->sync($tagList);
            }

            Session::flash('message', 'Амжилттай хадгалагдлаа!');
            return redirect()->route('post.showbySlug', array('slug' =>$post->slug))
                                ->with('status', 'success');
        }
    }
}
