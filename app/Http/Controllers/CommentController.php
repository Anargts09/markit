<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\Converter;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Post;
use App\Comment;

use Response, Auth, Input, View;

class CommentController extends Controller
{

    protected $converter;

    public function __construct(Converter $converter){
        $this->converter = $converter;
    }
    public function addComment($slug){

        $post = Post::findBySlug($slug);
        $user   = Auth::user();


        $newComment                  = new Comment;
        $newComment->post_id         = $post->id;
        $newComment->body            = htmlentities(Input::get('body'));
        $newComment->user_id         = $user->id;
        $newComment->save();
        $comment = $newComment;

        $user->increment('comment_count');
        $post->increment('comment_count'); 

        $markdown = $this->converter->convertToHtml(html_entity_decode($comment->body));

        $view=View::make('ajax.comment')
                ->with(compact('comment'))
                ->with(compact('markdown'))
                ->with(compact('user'));

        $html=$view->render();
        return Response::json(array('html'=>$html));

    }

    public function getAjaxComments($slug){

        $post = Post::findBySlug($slug);
        $comments  = Comment::where('post_id', '=', $post->id)->orderBy('created_at', 'desc')->paginate(5);
        $user = '';
        if(Auth::user()){
            $user = Auth::user(); 
        }

        $result = array();
        foreach ($comments as $k => $comment) {
            $markdown = $this->converter->convertToHtml(html_entity_decode($comment->body));
            $result[$k] = $markdown;
        }

        $view=View::make('ajax.comments')
            ->with('comments',$comments)
            ->with('result',$result)
            ->with('user',$user);
        $html=$view->render();

        return Response::json(array('html'=>$html));
    }

}
