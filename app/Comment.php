<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['body', 'post_id', 'user_id'];


    public function post(){
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

}
