<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

use Gravatar, Image, Avatar;
use App\Follower;
use App\TagFollow;
use App\Postsave;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, SluggableInterface
{
    use Authenticatable, CanResetPassword, SluggableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $sluggable = [
        'build_from' => 'username',
        'save_to'    => 'slug',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'first_name', 'last_name', 'provider', 'avatar', 'avatar1', 'gravatar', 'avatar_type', 'email_open', 'company', 'bio', 'webblog', 'user_language', 'last_login'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'provider_id', 'role'];

    public function userImage(){
        if($this->avatar_type == '1') return $this->avatar;
        if($this->avatar_type == '2') return Gravatar::src($this->email);
        if($this->avatar_type == '3'){
            $avatar = Avatar::create($this->username)->toBase64();
            // $image = (string) Image::make($avatar)->encode('png', 100);
            return $avatar;
            return Avatar::create($this->username); // Or wherever you get your string from
        }
        if($this->avatar_type == '4') return $this->avatar1;
        return false;
    }

    public function followers(){
        return $this->belongsToMany('App\User', 'followers', 'follow_id', 'user_id')->withTimestamps();
    }

    public function following(){
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follow_id')->withTimestamps();
    }
    public function followingSix(){
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follow_id')->take(6)->withTimestamps();
    }
    public function followerSix(){
        return $this->belongsToMany('App\User', 'followers', 'follow_id', 'user_id')->take(6)->withTimestamps();
    }

    public function followingId(){
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follow_id')->select(array('user_id'));
    }

    public function followCheck($fid){
        $uid=$this->id;
        $check=Follower::where(function($query) use ($uid,$fid){
            $query->where('user_id',$uid)->where('follow_id', $fid);
        })->get();
        if (!$check->isEmpty()) return true;
        return false;
    }

    public function tagFollowCheck($fid){
        $uid=$this->id;
        $check=TagFollow::where(function($query) use ($uid,$fid){
            $query->where('user_id',$uid)->where('tag_id', $fid);
        })->get();
        if (!$check->isEmpty()) return true;
        return false;
    }

    public function posts(){
        return $this->hasMany('App\Post')->where('status', true)->orderBy('created_at', 'desc');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'tag_user_pivot', 'user_id', 'tag_id');
    }

    public function drafts(){
        return $this->hasMany('App\Post')->where('status', false)->orderBy('created_at', 'desc');
    }

    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    public function followtags(){
        return $this->belongsToMany('App\Tag', 'tagfollowers', 'user_id', 'tag_id')->withTimestamps();
    }
    public function followtagsFive(){
        return $this->belongsToMany('App\Tag', 'tagfollowers', 'user_id', 'tag_id')->take(5)->withTimestamps();;
    }

    public function savedposts(){
        return $this->belongsToMany('App\Post', 'post_saves', 'user_id', 'post_id')->where('status', true)->orderBy('created_at', 'desc')->withTimestamps();
    }
    public function postSaveCheck($fid){
        $uid=$this->id;
        $check=Postsave::where(function($query) use ($uid,$fid){
            $query->where('user_id',$uid)->where('post_id', $fid);
        })->get();
        if (!$check->isEmpty()) return true;
        return false;
    }
}
