<?php

Route::group(['middleware' => 'admin'], function(){
    //тут роуты только для админа + авторизация
    Route::get('/', ['as' => 'admin.dashboard', function () {
        $content = 'Define your dashboard here.';
        return AdminSection::view($content, 'Dashboard');
    }]);


    Route::get('information', ['as' => 'admin.information', function () {
        $content = 'Define your information here.';
        return AdminSection::view($content, 'Information');
    }]);

    Route::get('users_table/{subject}', [
        'as' => 'admin.users_table',
        'uses' => '\App\Http\Controllers\UserHomeController@userTable'
    ]);

    /* Задачи */
    Route::post('process/{subject}/group', ['as' => 'group','uses'=>'\App\Http\Controllers\ProcessController@getUsers']);
    Route::post('process/{subject}/user', ['as' => 'user','uses'=>'\App\Http\Controllers\ProcessController@getStages']);
    Route::post('process/{subject}/stage', ['as' => 'stage','uses'=>'\App\Http\Controllers\ProcessController@getProgress']);
    Route::post('process/{subject}/task', ['as' => 'task','uses'=>'\App\Http\Controllers\ProcessController@getTasks']);
    Route::get('process/{subject}/{set_id}', ['as' => '{subject}/{set_id}','uses'=>'\App\Http\Controllers\ProcessController@getTable']);
    Route::post('process/{subject}/save', ['as' => 'save','uses'=>'\App\Http\Controllers\ProcessController@saveProcess']);
    /* Список задач */
    Route::get('setoftask/{subject}', ['as' => 'setoftask', 'uses' => 'App\Http\Controllers\ProcessController@getSetOfTasks']);
    Route::post('tasks_cart/{subject}', ['as' => 'tasks_cart', 'uses' => 'App\Http\Controllers\CartController@getSetOfTasks']);
    Route::post('tasks_cart/save/{subject}', ['as' => 'tasks_cart_save', 'uses' => 'App\Http\Controllers\CartController@saveSetOfTasks']);
    Route::post('tasks_cart/detach/{subject}', ['as' => 'tasks_cart_detach', 'uses' => 'App\Http\Controllers\CartController@detachSetOfTask']);

    /* Таблица рейтинга */
    Route::get('user_home/{subject}/{user_id}', ['as' => 'user_home', 'uses' => '\App\Http\Controllers\UserHomeController@userProfileView']);
    Route::get('users_table/{subject}/user_upgrade_skills', ['as' => 'user_upgrade_skills', 'uses' => '\App\Http\Controllers\ProgressController@upgradeSkillsUser']);

    /* Импорт */
    Route::get('import', ['as' => 'import', 'uses' => '\App\Http\Controllers\ImportController@getIndex']);
    Route::post('importExcel', ['as' => 'importExcel', 'uses' => '\App\Http\Controllers\ImportController@importExcel']);
    Route::get('parse_html', ['as' => 'parse_html', 'uses' => '\App\Http\Controllers\ImportController@getContent']);
    /* Экспорт */
    Route::get('setoftask/pdfviewtasks/{subject}', ['as' => 'pdfviewtasks', 'uses' => '\App\Http\Controllers\ExportController@pdfView']);
    Route::get('setoftask/pdfviewlist/{subject}', ['as' => 'pdfviewlist', 'uses' => '\App\Http\Controllers\ExportController@pdfView']);
    Route::get('setoftask/pdfviewlist/{subject}/ajax/group', ['as' => 'group_export/{subject}', 'uses' => '\App\Http\Controllers\ExportController@getGroupUsers']);

    /* Для управления миссии mission */
    Route::prefix('list_missions')->group(function () {
        Route::get('/', ['as' => 'list_missions', 'uses' => 'App\Http\Controllers\UserMissionController@getMissions']);
        Route::get('create_mission', ['as' => 'create_mission', 'uses' => '\App\Http\Controllers\UserMissionController@CreateFormMission']);
        Route::get('edit_mission/{mission_id}', ['as' => 'edit_mission', 'uses' => '\App\Http\Controllers\UserMissionController@EditFormMission']);
        Route::get('delete_mission/{mission_id}', ['as' => 'delete_mission', 'uses' => '\App\Http\Controllers\UserMissionController@deleteMission']);
        Route::post('edit_mission/save', ['as' => 'edit_mission_save', 'uses' => '\App\Http\Controllers\UserMissionController@saveMission']);
        Route::post('send_mission', ['as' => 'send_mission', 'uses' => '\App\Http\Controllers\UserMissionController@saveMission']);;
        Route::post('list_tasks', ['as' => 'list_tasks', 'uses' => '\App\Http\Controllers\UserMissionController@getTasks']);
        Route::post('edit_mission/list_tasks', ['as' => 'edit_list_tasks', 'uses' => '\App\Http\Controllers\UserMissionController@getTasks']);
    });
    /* Для рассылки newsletters */
    Route::get('mail', ['as' => 'mail', 'uses' => '\App\Http\Controllers\NewsletterController@index']);
    Route::post('mail/send', ['as' => 'send', 'uses' => '\App\Http\Controllers\NewsletterController@getMessage']);

    /*Регулярное выражение на валидацию параметра*/
    Route::get('test/{mission_id}', ['as' => 'test', 'uses' => '\App\Http\Controllers\UserMissionController@getMissions']);

    /*ckeditor при upload image */
    Route::post('ckeditor/upload', [
        'as'   => 'upload.image.s3',
        'uses' => "\App\Http\Controllers\ImageController@storeAdmin"
    ]);

    /*Получение списка exams_result*/
    Route::post('exam_results/{id}', [
        'as'   => 'exams_results',
        'uses' => "\App\Http\Controllers\ExamsController@examResults"
    ]);
    Route::post('exam_answer/{id}', [
        'as'   => 'exam_answer',
        'uses' => "\App\Http\Controllers\ExamsController@examAnswers"
    ]);

});