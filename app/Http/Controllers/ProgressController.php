<?php

namespace App\Http\Controllers;
use App\Models\Progress;
use App\User;
use DB;
use Illuminate\Http\Request;

use App\Helpers\JoinSubjects as Subjects;
use Illuminate\Http\Response;

class ProgressController extends Controller
{
    /**
     * @param Request $request object
     * @param string $subject
     * @return string
     * Функция собирает данные из таблицы progress и tasks
     * Выбирает по трудности задач, группирует по полям user_id, section_id, number_lesson
     * И закидывает в таблицу grade
     * */
    public function upgradeSkillsUser(Request $request, string $subject): string{

        if($request->has('upgrade')){
            return $this->subjectTableUpdate($subject);
        }

        return 'Недоступная операция!';
    }

    public function subjectTableUpdate(string $subject): string {

        $grades = ['D', 'C', 'B', 'A'];

        $_subject = Subjects::_Subject($subject);
        $modelGrade = 'App\Models\Grade'.ucfirst($subject);

        //Обновление данных и генерирования progress
        $progressUpdate = $this->buildProgress($subject);

        //Возьмём последние даты из таблиц grade и processes для сравнения
        $last_record_grade = DB::table('grade'.$_subject)->latest('id')->value('created_at');
        $last_record_processes = DB::table('processes'.$_subject)->latest('id')->value('created_at');

        if($last_record_processes > $last_record_grade){

            foreach ($grades as $grade):

                $query_grade_chars = DB::table('processes'.$_subject.' as pr')
                    ->leftJoin('tasks'.$_subject.' as t' , 'pr.number_task', '=', 't.number_task')
                    ->select(DB::raw('count(*) as count, t.section_id, pr.user_id, pr.number_lesson, sum(pr.experience) as sum_exp, sum(pr.gold) as sum_gold, sum(pr.crystal) as sum_crystal'))
                    ->where('t.grade', '=' , $grade);

                //Если таблица grade не пуста
                if(!empty($last_record_grade)){
                    $query_grade_chars = $query_grade_chars
                        ->where('pr.created_at', '>', $last_record_grade)
                        ->groupBy('user_id', 't.section_id', 'pr.number_lesson');
                }

                $grade_chars = $query_grade_chars->get();

                foreach ($grade_chars as $grade_char):

                    //Done::создать динамическую генерацию модели от subject
                    $modelGrade::create([
                        'section_id' => $grade_char->section_id,
                        'user_id' => $grade_char->user_id,
                        'sum_tasks' => $grade_char->count,
                        'number_lesson' => $grade_char->number_lesson,
                        'grade_char' => $grade,
                        'sum_exp' => $grade_char->sum_exp,
                        'sum_gold' => $grade_char->sum_gold,
                        'sum_crystal' => $grade_char->sum_crystal
                    ]);
                endforeach;
            endforeach;

            return 'Общая статистика успешно обновилась! '.$progressUpdate;
        }
        else{
            return 'У вас актуальные данные на сегодняшний день!';
        }
    }

    /**
     * @param string $subject - название предмета по которому определяется набор таблиц
     * @return string
     * Генерируем из данных таблицы grade статистику по grade и section_id, сверяем с таблицей categories_{subjects} и progress.
     * После записываем в таблицу users_progress
     * TODO: Доработать генерацию progress -> super_progress выдаётся из выполнения условий из таблицы user_progress
     * @return Response
     */
    public function buildProgress(string $subject) :string
    {
        $arr = [];
        $_subject = Subjects::_Subject($subject);
        $progresses = Progress::all();

        $arrayStat = [];
        $arrayUsers = [];

        foreach ($progresses as $progress):

            //Расщепляем строку на элементы массива
            $array_count_tasks = explode(',',$progress->list_count_tasks);
            foreach ($array_count_tasks as $list_count_task):
                //Разбиваем строку вида D:1 на массив из двух элементов
                $array_count_task = explode(':', $list_count_task);

                $grade = $array_count_task[0];
                $count_task = $array_count_task[1];
                //Создаём запрос чтобы вытащить данные из статистики таблицы grade, сгруппированные по s.category_id, gr.grade_char, user_id
                $stats = DB::select('
                            select g.sum_t, g.grade_char, g.user_id from
                            (select sum(t.sum_t) as sum_t, t.grade_char, t.user_id from
                            (select count(*) as count_tasks, sum(sum_tasks) as sum_t, gr.grade_char, gr.user_id from grade'.$_subject.' as gr
                            left join users on gr.user_id = users.id 
                            left join sections'.$_subject.' as s on s.id = gr.section_id
                            where s.category_id in ('.$progress->list_categories_id.') and gr.grade_char in ("'.$grade.'")
                            group by s.category_id, gr.section_id, gr.grade_char, user_id) as t 
                            group by grade_char, user_id) as g where g.sum_t >= '.$count_task.' order by g.user_id asc');

                if(!empty($stats)){
                    foreach($stats as $stat):

                        $user_id = $stat->user_id;
                        $sum_t = $stat->sum_t;
                        $grade = $stat->grade_char;
                        //Наполняем массив users для создания фильтрации значений, которые будут в случае совпадения заменяться
                        $arrayUsers[$user_id] = $user_id;
                        //Динамически создаём вложенный массив для фильтрации о объединения данных в свои ячейки массива
                        $arrayStat[$progress->type][$progress->rank][$user_id][$grade] = $sum_t;
                    endforeach;
                }
            endforeach;
        endforeach;

        //Проводим сравнение с данными таблицей progress, на совпадение статистики
        foreach ($progresses as $progress):

            $list_grade = explode(',' ,$progress->list_grade);
            $count = count($list_grade);

            foreach ($arrayUsers as $user):

                //Если юзера нет с параметрами progress, далее не рассматриваем
                if(!empty($arrayStat[$progress->type][$progress->rank][$user])){
                    //array_push($arr, (Object)['user_id' => $user, 'type' => $progress->type, 'rank' => $progress->rank, 'quality' => $progress->quality, 'stats' => $arrayStat[$progress->type][$progress->rank][$user]]);
                    //Основная проверка на длину массива, содержащего собранные данные пользователя для определения ранга в достижениях
                    if(count($arrayStat[$progress->type][$progress->rank][$user]) == $count) {

                        $user_progresses = User::find($user)->progresses();
                        $user_progress = $user_progresses->get()->where('id', $progress->id)->first();

                        if(!empty($user_progress)){
                            if($user_progress->pivot->progress_quality < $progress->quality){
                                $user_progresses->updateExistingPivot($progress->id, ['progress_quality' => $progress->quality]);
                            }else{
                                continue;
                            }
                        }else{
                            $user_progresses->attach($progress->id, ['progress_quality' => $progress->quality]);
                        }
                    }
                }
            endforeach;
        endforeach;

        return response()->json('Достижения учеников обновлены!');
    }

    /**
     * @return void
     * @param string $subject - название предмета по которому определяется набор таблиц
     * Собираем данные их таблицы users_progress и progress
     * Выводим шаблон интерфейс
     */
    public function getTableProgress(string $subject)
    {

    }



}
