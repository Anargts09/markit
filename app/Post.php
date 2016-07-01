<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Auth;

class Post extends Model implements SluggableInterface
{
    use SluggableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
        'on_update'  => true,
        'max_length' => 30,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'user_id'];

    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'post_tag_pivot', 'post_id', 'tag_id');
    }

    public function savedusers(){
        return $this->belongsToMany('App\User', 'post_saves', 'post_id', 'user_id')->withTimestamps();
    }

    public function savedUsersEl(){
        return $this->belongsToMany('App\User', 'post_saves', 'post_id', 'user_id')->take(11)->withTimestamps();
    }

    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc')->take(5);
    }

}
