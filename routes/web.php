<?php
//Если названия роутеров совпадают as pages, то вызвает ошибку совпадения роутеров по имени
//Lp
use App\Http\Controllers\PageController;
use App\Models\Page;

Route::get('egorperl', function () {
    return view('egorperl');
});

Route::get('/', function () {
    return view('main');
});

$pages = Page::all();

foreach ($pages as $page) {
    Route::get($page->link, [PageController::class, 'showPage']);
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
    Route::get('{id}/{link?}', ['as' => 'post', 'uses' => 'BlogController@showPost'])->where('id', '[0-9]+');// регулярное выражение для параметра проверки link
    Route::get('tag/{name}/{id}', ['as' => 'tag', 'uses' => 'BlogController@showPostsForTag']);
    Route::get('author/{name}/{id}', ['as' => 'author', 'uses' => 'BlogController@showPostsOfAuthor']);
    Route::post('/{post_id}', ['as' => 'save_comments', 'uses' => 'CommentsController@saveComment'])->where('post_id', '[0-9]+');
});


//Регистрация
Route::group(['middleware' => 'auth'], function(){
    Route::get('v2', function(){
        return view('test');
    });

    Route::get('v3', function(){
        return view('test1');
    });

    Route::group(['middleware' => ['admin']], function(){
        //тут роуты только для админа + авторизация
    });
});

Auth::routes();

//Messenger - chat
Route::get('/home/messages', ['as' => 'messages.home', 'uses' => 'MessagesController@index']);
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

//New education game
Route::post('profile/exam/{id?}', ['as' => 'exam', 'uses' => 'ExamsController@examUserInfo']);
Route::post('profile/interface/{subject}', ['as' => 'interface', 'uses' => 'UserHomeController@userProfileBuild']);
Route::get('profile/table_tasks/{subject}/{mission_id}', ['as' => 'mission_id', 'uses' => 'UserMissionController@getTasks']);
Route::post('profile/all', ['as' => 'complete_profile', 'uses' => 'UserHomeController@userProfile']);
Route::post('profile/item', ['as' => 'equip', 'uses' => 'UserHomeController@userEquipArtifact']);
Route::post('profile/shop_items', ['as' => 'shop', 'uses' => 'UserHomeController@userBuyArtifact']);

Route::get('home/users_rating/{subject}', ['as' => 'users_rating', 'uses' => 'UserHomeController@userTableRating']);
Route::get('home/user_solved_tasks', ['as' => 'user_solved_tasks', 'uses' => 'UserHomeController@userShowTasksSolved']);
Route::get('home/user_home/{subject}/{user_id}', ['as' => 'rating_math/{user_id}','uses'=>'UserHomeController@userProfileRating']);
Route::get('home/game_duel', ['as' => 'game_duel', 'uses' => 'GameDuelController@index']);

//Form регистрация школьников и родителей
Route::get('form', ['as' => 'form', 'uses' => 'ContactController@getForm']);
Route::post('from_registration', ['as' => 'from_registration', 'uses' => 'ContactController@saveForm']);


Route::get('json_tasks', ['as' => 'json_t', 'uses' => 'ExportController@getJsonTasks']);