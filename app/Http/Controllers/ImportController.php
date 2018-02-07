<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Excel;
use DB;
use Hash;
use AdminSection;

class ImportController extends Controller
{
    /**
     * @return view
     * Отправляем шаблон
     * */
    public function getIndex()
    {
        $view = view('admin.import.import', [1]);
        $view = AdminSection::view($view->renderSections()["innerContent"], '');
        return $view;
    }

    /**
     * @return string
     * Получаем данные их формы select и файл
     * Парсим excel файл в зависимости от типа данных, формируем массив
     * Записываем в БД
     * */
    public function importExcel()
    {

        $table_name = Input::get('import-select');

        if (Input::hasFile('import-file')) {
            $path = Input::file('import-file')->getRealPath();

            try {
                $data = Excel::load($path, function ($reader) {
                })->get();
            } catch (\Exception $e) {
                return view('errors.request', ['error' => $e->getMessage()]);
            }

            if (!empty($data) && $data->count()) {

                switch ($table_name) {

                    case 'subjects':

                        $data->each(function ($sheet) {

                            if ($sheet->getTitle() == 'subjects') {

                                foreach ($sheet as $key => $value) {
                                    $insert[] = [
                                        'name' => $value->name,
                                        'category_id' => $value->category_id,
                                        'code' => $value->code,
                                    ];
                                }

                                if (!empty($insert)) {
                                    DB::table('subjects')->insert($insert);
                                }
                            }

                            if ($sheet->getTitle() == 'categories_subjects') {

                                foreach ($sheet as $key => $value) {
                                    $insert[] = [
                                        'name' => $value->name,
                                        'parent_category_id' => $value->parent_category_id,
                                        'code' => $value->code,
                                    ];
                                }

                                if (!empty($insert)) {
                                    DB::table('categories_subjects')->insert($insert);
                                }
                            }
                        });
                        break;

                    case 'subjects_physics':

                        $data->each(function ($sheet) {

                            if ($sheet->getTitle() == 'subjects_physics') {

                                foreach ($sheet as $key => $value) {
                                    $insert[] = [
                                        'name' => $value->name,
                                        'category_id' => $value->category_id,
                                        'code' => $value->code,
                                    ];
                                }

                                //dd($insert);
                                if (!empty($insert)) {
                                    DB::table('subjects_physics')->insert($insert);
                                }
                            }

                            if ($sheet->getTitle() == 'categories_subjects_physics') {

                                foreach ($sheet as $key => $value) {
                                    $insert[] = [
                                        'name' => $value->name,
                                        'parent_category_id' => $value->parent_category_id,
                                        'code' => $value->code,
                                    ];
                                }

                                if (!empty($insert)) {
                                    DB::table('categories_subjects_physics')->insert($insert);
                                }
                            }
                        });
                        break;

                    case 'tasks':
                        
                        //выбираем последнюю в таблице по номеру задачу
                        $last_task = DB::table('tasks')->latest('number_task')->first();

                        foreach ($data as $key => $value) {

                            //Проверяем если есть задачи, то выбираем последнюю в таблице по номеру задачу
                            if (!empty($last_task))
                                $last_number_task = $last_task->number_task;
                            else
                                $last_number_task = 0;

                            if (empty($value->number_task) || $value->number_task <= $last_number_task) {
                                continue;
                            }

                            $insert[] = [
                                'number_task' => $value->number_task,
                                'task' => $value->task,
                                'image' => $value->image,
                                'experience' => $value->experience,
                                'gold' => $value->gold,
                                'grade' => $value->grade,
                                'subject_id' => $value->subject_id,
                                'answer' => $value->answer,
                                'detail' => $value->detail,
                                'set_of_task_id' => $value->set_of_task_id,
                                'original_number' => $value->original_number,
                                'book' => $value->book
                            ];
                        }

                        if (!empty($insert)) {
                            DB::table('tasks')->insert($insert);
                        }

                        break;

                    case 'tasks_physics':

                        //выбираем последнюю в таблице по номеру задачу
                        $last_task = DB::table('tasks_physics')->latest('number_task')->first();
                        foreach ($data as $key => $value) {

                            //Проверяем если есть задачи, то выбираем последнюю в таблице по номеру задачу
                            if (!empty($last_task))
                                $last_number_task = $last_task->number_task;
                            else
                                $last_number_task = 0;

                            if (empty($value->number_task) || $value->number_task <= $last_number_task) {
                                continue;
                            }

                            $insert[] = [
                                'number_task' => $value->number_task,
                                'task' => $value->task,
                                'image_1' => $value->image_1,
                                'image_2' => $value->image_2,
                                'image_1_answer' => $value->image_1_answer,
                                'image_2_answer' => $value->image_2_answer,
                                'experience' => $value->experience,
                                'gold' => $value->gold,
                                'grade' => $value->grade,
                                'subject_id' => $value->subject_id,
                                'answer' => $value->answer,
                                'detail' => $value->detail,
                                'set_of_task_id' => $value->set_of_task_id,
                                'original_number' => $value->original_number,
                                'book' => $value->book
                            ];
                        }

                        if (!empty($insert)) {
                            DB::table('tasks_physics')->insert($insert);
                        }

                        break;

                    case 'users':

                        foreach ($data as $key => $value) {

                            if (empty($value->name)) {
                                continue;
                            }

                            $insert[] = [
                                'email' => $value->email,
                                'password' => Hash::make($value->password),
                                'name' => $value->name,
                                'surname' => $value->surname,
                                'login' => $value->login,
                                'group' => $value->group,
                                'description' => $value->description,
                                'logins' => $value->logins,
                                'last_login' => $value->last_login,
                                'avatar' => $value->avatar,
                                'sex' => $value->sex,
                                'notify' => $value->notify,
                            ];
                        }

                        if (!empty($insert)) {
                            DB::table('users')->insert($insert);
                        }

                        break;

                    case 'processes':

                        $last_process_time = DB::table('processes')->latest('id')->value('created_at');

                        foreach ($data as $key => $value) {

                            $user_id = $value->user_id;

                            if (empty($user_id) || strtotime($value->created_at) <= strtotime($last_process_time)) {
                                continue;
                            }

                            $insert[] = [
                                'user_id' => $user_id,
                                'stage_id' => $value->stage_id,
                                'number_task' => $value->number_task,
                                'experience' => $value->experience,
                                'gold' => $value->gold,
                                'rating' => $value->rating,
                                'comment' => $value->comment,
                                'number_lesson' => $value->number_lesson,
                                'created_at' => $value->created_at
                            ];

                            //Закинуть в функцию добавить сравнение со временем последней записи
                            //И добавить записи больше этого времени
                            $progresses = $value->progress;
                            if ($progresses) {
                                $progress = explode('-', $progresses);
                                $progress_alias = $progress[0];
                                $progress_experience = $progress[1];
                                $progress_id = DB::table('progress')->where('alias', $progress_alias)->value('id');

                                $insert_progress[] = [
                                    'progress_id' => $progress_id,
                                    'user_id' => $user_id,
                                    'experience' => $progress_experience
                                ];
                            }
                        }

                        if (!empty($insert)) {
                            DB::table('processes')->insert($insert);
                        }

                        if (!empty($insert_progress)) {
                            DB::table('users_progress')->insert($insert_progress);
                        }

                        break;

                    case 'processes_physics':

                        $last_process_time = DB::table('processes_physics')->latest('id')->value('created_at');

                        foreach ($data as $key => $value) {

                            $user_id = $value->user_id;

                            if (empty($user_id) || strtotime($value->created_at) <= strtotime($last_process_time)) {
                                continue;
                            }

                            $insert[] = [
                                'user_id' => $user_id,
                                'stage_id' => $value->stage_id,
                                'number_task' => $value->number_task,
                                'experience' => $value->experience,
                                'gold' => $value->gold,
                                'rating' => $value->rating,
                                'comment' => $value->comment,
                                'number_lesson' => $value->number_lesson,
                                'created_at' => $value->created_at
                            ];
                        }

                        if (!empty($insert)) {
                            DB::table('processes_physics')->insert($insert);
                        }

                        break;
                }
            }
        }
        return 'Успешно! Данные импортированы.';
    }
}
