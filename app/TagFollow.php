<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagFollow extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'tagfollowers';

    protected $hidden = ['user_id', 'tag_id'];
}
