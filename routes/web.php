<?php
//Lp
Route::get('/', function () {
    return view('main');
});

$pages = \App\Models\Page::all();

foreach ($pages as $page) {

    Route::get($page->link, [
        'as' => 'pages',
        'uses' => 'PageController@showPage'
    ]);
}

Route::get('master_class', function () {
    return view('master_class');
});

Route::get('prize', function () {
    return view('prize');
});

Route::post('prize',[
    'as' => 'prize',
    'uses' => 'ContactController@prizeUsers'
]);

Route::post('contact',[
    'as' => 'contact',
    'uses' => 'ContactController@saveContact'
]);

//Страницы
Route::get('subject/{id}', [
    'as' => 'subject',
    'uses' => 'PageController@showPage'
]);

//Блог
Route::group(['prefix' => 'blog'], function(){
    Route::get('/', ['as' => 'posts_list', 'uses' => 'BlogController@showBlogList']);
    Route::get('list', ['as' => 'json_blog_list', 'uses' => 'BlogController@jsonBlogList']);
    Route::get('{id}', ['as' => 'post', 'uses' => 'BlogController@showPost'])->where('id', '[0-9]+');// регулярное выражение для параметра проверки link
    Route::get('tag/{name}/{id}', ['as' => 'tag', 'uses' => 'BlogController@showPostsForTag']);
    Route::get('author/{name}/{id}', ['as' => 'author', 'uses' => 'BlogController@showPostsOfAuthor']);
    Route::post('/{post_id}', ['as' => 'save_comments', 'uses' => 'CommentsController@saveComment'])->where('post_id', '[0-9]+');
});


//Регистрация
Route::group(['middleware' => 'auth'], function(){
    Route::group(['middleware' => 'admin'], function(){
        //тут роуты только для админа + авторизация
        Route::get('/add', 'BlogController@addPost');
    });
});

Auth::routes();

//Messenger - chat
Route::get('/home/messages', ['as' => 'messages', 'uses' => 'MessagesController@index']);
Route::group(['prefix' => 'messages', 'before' => 'auth'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::get('{id}/read', ['as' => 'messages.read', 'uses' => 'MessagesController@read']);
    Route::get('unread', ['as' => 'messages.unread', 'uses' => 'MessagesController@unread']);
    Route::post('store', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    //Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
    Route::post('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('home/users_rating/{subject}', ['as' => 'users_rating', 'uses' => 'UserHomeController@userTableRating']);
Route::get('home/user_solved_tasks', ['as' => 'user_solved_tasks', 'uses' => 'UserHomeController@userShowTasksSolved']);
Route::get('home/user_home/{subject}/{user_id}', ['as' => 'rating_math/{user_id}','uses'=>'\App\Http\Controllers\UserHomeController@userProfileRating']);
Route::get('home/game_duel', ['as' => 'game_duel', 'uses' => 'GameDuelController@index']);

Route::get('test', function(){
    return view('test');
});