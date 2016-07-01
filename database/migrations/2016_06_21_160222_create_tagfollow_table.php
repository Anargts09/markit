<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagfollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagfollowers', function ($table)
        {
            $table->integer('user_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->primary(array('user_id','tag_id'));
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->index('user_id');
            $table->index('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tagfollowers');
    }
}
