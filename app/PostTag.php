<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'post_tag_pivot';

    protected $hidden = ['post_id', 'tag_id'];
}
