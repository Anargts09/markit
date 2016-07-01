<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postsave extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'post_saves';

    protected $hidden = ['user_id', 'post_id'];
}
