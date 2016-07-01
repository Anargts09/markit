<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Нүүр хуудас
// Route::get('/testtesttest',            	['as' => 'test',        	'uses'	=> 'TestController@index']);

// Нүүр хуудас
Route::get('/',            	['as' => 'index',        	'uses'	=> 'HomeController@index']);
// Бүх тагуудыг үзэх
Route::get('/alltag', ['as' => 'tag.listAll', 			'uses'	=> 'TagController@listAll']);
// Бүх хэрэглэгч үзэх
Route::get('/alluser', ['as' => 'user.listUser', 		'uses'	=> 'UserController@listAll']);
// Post үзэх
Route::get('/post/{slug}', 	['as' => 'post.showbySlug', 'uses'	=> 'PostController@showPost']);
// Tag үзэх
Route::get('/tag/{slug}', 	['as' => 'tag.showbySlug', 	'uses'	=> 'TagController@showTag']);
// Хэрэглэгчийн Профайл үзэх
Route::get('/{slug}', 		['as' => 'user.profile',	'uses'	=> 'UserController@showProfile']);
// Хэрэглэгчийн дагагчид
Route::get('/{slug}/followers',['as' => 'user.showFollowers',	'uses'	=> 'UserController@showFollowers']);
// Хэрэглэгчийн дагаж байгаа хүмүүс
Route::get('/{slug}/followings',['as' => 'user.showFollowing',	'uses'	=> 'UserController@showFollowing']);

// Зөвхөн Ajax хүсэлтүүд
Route::group(['middleware' => 'ajax'], function(){
	// Ajax allpost pagination
	Route::post('/postsajax',	['as' => 'index.ajaxpost',    'uses'	=> 'AjaxController@getAjaxPost']);
	// AJAX FIRST 10 Comment
	Route::post('/post/{slug}/comments',	['as' => 'post.ajaxComment',    'uses'	=> 'AjaxController@getAjaxComments']);
	Route::group(['middleware' => 'auth'], function(){
		// AjaxFeed pagination
		Route::post('/feedajax',	['as' => 'index.ajaxfeed',    'uses'	=> 'AjaxController@getAjaxFeed']);
		// Comment AJAX POST
		Route::post('/post/{slug}/addcomment',	['as' => 'comment.add',    'uses'	=> 'CommentController@addComment']);
	});
});

// Нэвтрэх болон бүртгүүлэх
Route::group(['prefix' => 'auth'], function () {
	$a = 'auth.';
	Route::get('/login',            ['as' => $a . 'login',          'uses' => 'Auth\AuthController@getLogin']);
	Route::post('/login',           ['as' => $a . 'login-post',     'uses' => 'Auth\AuthController@postLogin']);
	Route::get('/register',         ['as' => $a . 'register',       'uses' => 'Auth\AuthController@getRegister']);
	Route::post('/register',        ['as' => $a . 'register-post',  'uses' => 'Auth\AuthController@postRegister']);
	Route::get('/password',         ['as' => $a . 'password',       'uses' => 'Auth\PasswordController@getPasswordReset']);
	Route::post('/password',        ['as' => $a . 'password-post',  'uses' => 'Auth\PasswordController@postPasswordReset']);
	Route::get('/password/reset/{token}', ['as' => $a . 'reset',          'uses' => 'Auth\PasswordController@getPasswordResetForm']);
	Route::post('/password/reset/{token}',['as' => $a . 'reset-post',     'uses' => 'Auth\PasswordController@postPasswordResetForm']);
});

// Socialite Routes
Route::group(['prefix' => 'social'], function () {
	$s = 'social.';
	Route::get('/redirect/{provider}',   ['as' => $s . 'redirect',	'uses' => 'Auth\AuthController@getSocialRedirect']);
	Route::get('/handle/{provider}',     ['as' => $s . 'handle',	'uses' => 'Auth\AuthController@getSocialHandle']);
});


// Дээрхээс бусад бүх Route нэвтэрсэн үгүйг шалгана
Route::group(['middleware' => 'auth'], function(){
    $a = 'user.';
    // Системээс гарах
    Route::get('/user/logout', ['as' => $a . 'logout', 				'uses'	=> 'Auth\AuthController@getLogout']);
	// Профайлаа засах
	Route::get('/settings/profile', ['as' => $a. 'get-editprofile',	'uses' 	=> 'UserController@getEditProfile']);
	Route::get('/settings/account', ['as' => $a. 'get-editaccount',	'uses' 	=> 'UserController@getEditAccount']);
	Route::get('/settings/account/custom_image', ['as' => $a. 'get-imageupload','uses' 	=> 'UserController@getImageUpload']);
	// Профайлаа засах
	Route::post('/settings/profile', ['as' => $a. 'post-editprofile','uses' => 'UserController@postEditProfile']);
	Route::post('/settings/account', ['as' => $a. 'post-editaccount','uses' => 'UserController@postEditAccount']);
	Route::post('/settings/account/custom_image', ['as' => $a. 'post-imageupload','uses' 	=> 'ImageController@postProfileImage']);
});

// Пост бичих засах үзэх
Route::group(['middleware' => 'auth'], function(){
    $p = 'post.';
    // Пост бичих
    Route::get('/drafts/new', ['as' => $p . 'addnew', 			'uses'	=> 'PostController@getNew']);
    Route::post('/drafts/new', ['as' => $p . 'postnew', 		'uses'	=> 'PostController@postNew']);
    // Пост засах 
    Route::get('/edit/{slug}', ['as' => $p . 'editPost', 		'uses'	=> 'PostController@editPost']);
    Route::post('/edit/{slug}', ['as' => $p . 'postEditPost', 	'uses'	=> 'PostController@postEditPost']);
    // Пост хадгалах 
    Route::post('/savepost/{id}',   ['as' =>$p . 'save',		'uses'	=> 'FollowerController@postSave']);
	Route::post('/unsavepost/{id}', ['as' =>$p . 'unsave',		'uses'	=> 'FollowerController@postUnsave']);
});


Route::group(['middleware' => 'ajax'], function(){
	// Хэрэглэгч дагах 
	Route::group(['middleware' => 'auth'], function(){
	    $f = 'follow.';
	    // Хүн дагах
	    Route::post('/follow/{id}',   ['as' =>$f . 'add',		'uses'	=> 'FollowerController@userFollow']);
	});
	// Tag дагах
	Route::group(['middleware' => 'auth'], function(){
	    $p = 'tag.';
	    // Таг хуудас    
	    Route::get('/api/alltag', ['as' => $p . 'showall', 			'uses'	=> 'TagController@showAll']);
	    // Таг дагах
	    Route::post('/tagfollow/{id}',   ['as' =>$p . 'follow',		'uses'	=> 'FollowerController@tagFollow']);
		Route::post('/tagunfollow/{id}', ['as' =>$p . 'unfollow',	'uses'	=> 'FollowerController@tagUnfollow']);
	});
});

