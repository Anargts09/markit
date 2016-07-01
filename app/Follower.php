<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'followers';

    protected $hidden = ['user_id', 'follow_id'];
}
