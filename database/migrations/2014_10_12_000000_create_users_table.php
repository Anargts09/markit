<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('username');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('slug')->unique()->index();
            $table->string('provider');
            $table->string('provider_id')->nullable();
            $table->string('email')->nullable();
            $table->string('password', 60)->nullable();
            $table->string('role')->default('user');
            $table->string('avatar');
            $table->string('avatar1');
            $table->string('gravatar');
            $table->string('avatar_type')->default('1');
            $table->boolean('email_open')->default(false);
            $table->string('company');
            $table->text('bio');
            $table->string('webblog')->nullable();
            $table->string('user_language')->default('en');
            $table->timestamp('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('followers_count')->default(0);
            $table->integer('following_count')->default(0);
            $table->integer('saveitem_count')->default(0);
            $table->integer('item_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('notif_count')->default(0);
            $table->integer('user_point')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
