<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Tag extends Model implements SluggableInterface
{
    use SluggableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'tag_image'];


    public function posts(){
        return $this->belongsToMany('App\Post', 'post_tag_pivot', 'tag_id', 'post_id');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'tag_user_pivot', 'tag_id', 'user_id');
    }

    public function followusers(){
        return $this->belongsToMany('App\User', 'tagfollowers', 'tag_id', 'user_id')->withTimestamps();
    }
}
