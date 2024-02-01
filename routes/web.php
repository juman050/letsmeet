<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::post('/login','HomeController@userlogin');
Route::get('/home', 'MeetController@index');
Route::get('/profile', 'MeetController@profile');
Route::post('/profile/update', 'MeetController@updateUser');
Route::post('/profile/upload', 'MeetController@uploadImage');
Route::get('/logout', 'MeetController@logout');

/**post**/

Route::post('/add-post', 'MeetController@createPost');
Route::post('/create-post', 'MeetController@addPost');
Route::get('/delete-post/{id}', 'MeetController@removePost');

/**users**/

Route::get('/user-profile/{id}', 'MeetController@userProfile');
Route::get('/find-people', 'MeetController@findUser');
Route::post('/search-user', 'MeetController@searchUser');

/**follow/unfollow**/

Route::post('/follow', 'MeetController@follow');
Route::post('/unfollow', 'MeetController@unfollow');

/**like/dislike**/

Route::post('/like', 'MeetController@like');
Route::post('/dislike', 'MeetController@dislike');

/**message module**/

Route::get('/conversations', 'MeetController@conversations');
Route::get('/get-all-conversations', 'MeetController@getConversations');
Route::get('/get-conversation-message/{id}', 'MeetController@getConversationMsg');
Route::post('/sendMessage', 'MeetController@sendMessage');
Route::post('/sendNewMessage', 'MeetController@sendNewMessage');
Route::get('/newMessage', 'MeetController@newMessage');


/**comment module**/

Route::post('/add-comment', 'MeetController@addComment');
// Route::post('/add-reply', 'MeetController@addReply');

//**activity module**//
Route::get('/activity', 'MeetController@activity');
Route::post('/create-activity', 'MeetController@createActivity');
Route::post('/find-location', 'MeetController@findLocation');

