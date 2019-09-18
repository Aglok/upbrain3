<?php namespace App\Http\Controllers;

use function explode;
use Illuminate\Support\Facades\Input;
use Excel;
use DB;
use Hash;
use AdminSection;
use App\Helpers\ParserSh;
use Symfony\Component\DomCrawler\Crawler;

class ImportController extends Controller
{
    /**
     * @return view
     * Отправляем шаблон
     * */
    public function getIndex()
    {
        $view = view('admin.import.import', [1]);
        return AdminSection::view($view->renderSections()["innerContent"], '');
    }

    /**
     * @return string
     * Получаем данные их формы select и файл
     * Парсим excel файл в зависимости от типа данных, формируем массив
     * Записываем в БД
     * */
    //TODO::Excel::load replace import($import, request()->file('import_file')); $import = new UsersImport();
    public function importExcel()
    {

        $table_name = explode('_', Input::get('import-select'));

        $table = $table_name[0];
        $subject = '';

        //Если название таблицы users
        if(count($table_name) > 1)
            $subject = $table_name[1];

        if (Input::hasFile('import-file')) {
            $file = Input::file('import-file');


            if($table == 'section' && $subject){
                Excel::import(new \App\Imports\SheetsSectionsImport($subject), $file);
            }elseif ($table == 'tasks' && $subject){
                Excel::import(new \App\Imports\TasksImport($subject), $file);
            }elseif ($table == 'users'){
                Excel::import(new \App\Imports\UsersImport($subject), $file);
            }elseif($table == 'processes' && $subject){
                Excel::import(new \App\Imports\ProcessesImport($subject), $file);
            }else{
                return "Таких таблиц нет!";
            }

//TODO:: доделать с моделями UsersImport, ProcessesImport

//                switch ($table_name) {
//
//                    case 'users':
//
//                        foreach ($data as $key => $value) {
//
//                            if (empty($value->name)) {
//                                continue;
//                            }
//
//                            $insert[] = [
//                                'email' => $value->email,
//                                'password' => Hash::make($value->password),
//                                'name' => $value->name,
//                                'surname' => $value->surname,
//                                'login' => $value->login,
//                                'group' => $value->group,
//                                'description' => $value->description,
//                                'logins' => $value->logins,
//                                'last_login' => $value->last_login,
//                                'avatar' => $value->avatar,
//                                'sex' => $value->sex,
//                                'notify' => $value->notify,
//                            ];
//                        }
//
//                        if (!empty($insert)) {
//                            DB::table('users')->insert($insert);
//                        }
//
//                        break;
//
//                    case 'processes_math':
//
//                        $last_process_time = DB::table('processes_math')->latest('id')->value('created_at');
//
//                        foreach ($data as $key => $value) {
//
//                            $user_id = $value->user_id;
//
//                            if (empty($user_id) || strtotime($value->created_at) <= strtotime($last_process_time)) {
//                                continue;
//                            }
//
//                            $insert[] = [
//                                'user_id' => $user_id,
//                                'stage_id' => $value->stage_id,
//                                'number_task' => $value->number_task,
//                                'experience' => $value->experience,
//                                'gold' => $value->gold,
//                                'rating' => $value->rating,
//                                'comment' => $value->comment,
//                                'number_lesson' => $value->number_lesson,
//                                'created_at' => $value->created_at
//                            ];
//
//                            //Закинуть в функцию добавить сравнение со временем последней записи
//                            //И добавить записи больше этого времени
//                            $progresses = $value->progress;
//                            if ($progresses) {
//                                $progress = explode('-', $progresses);
//                                $progress_alias = $progress[0];
//                                $progress_experience = $progress[1];
//                                $progress_id = DB::table('progresses_math')->where('alias', $progress_alias)->value('id');
//
//                                $insert_progress[] = [
//                                    'progress_id' => $progress_id,
//                                    'user_id' => $user_id,
//                                    'experience' => $progress_experience
//                                ];
//                            }
//                        }
//
//                        if (!empty($insert)) {
//                            DB::table('processes_math')->insert($insert);
//                        }
//
//                        if (!empty($insert_progress)) {
//                            DB::table('users_progress')->insert($insert_progress);
//                        }
//
//                        break;
//
//                    case 'processes_physics':
//
//                        $last_process_time = DB::table('processes_physics')->latest('id')->value('created_at');
//
//                        foreach ($data as $key => $value) {
//
//                            $user_id = $value->user_id;
//
//                            if (empty($user_id) || strtotime($value->created_at) <= strtotime($last_process_time)) {
//                                continue;
//                            }
//
//                            $insert[] = [
//                                'user_id' => $user_id,
//                                'stage_id' => $value->stage_id,
//                                'number_task' => $value->number_task,
//                                'experience' => $value->experience,
//                                'gold' => $value->gold,
//                                'rating' => $value->rating,
//                                'comment' => $value->comment,
//                                'number_lesson' => $value->number_lesson,
//                                'created_at' => $value->created_at
//                            ];
//                        }
//
//                        if (!empty($insert)) {
//                            DB::table('processes_physics')->insert($insert);
//                        }
//
//                        break;
//                }
        }

        return 'Успешно! Данные импортированы.';
    }

    /**
     * Get content from html.
     *
     * @var $parser ParserSh object parser settings
     * @var $link string link to html page
     *
     * @return array with parsing data
     * @throws \Exception
     */

    public function getContent(ParserSh $parser)
    {
        // Get html remote text.
        $html = file_get_contents($parser->link);
        // Create new instance for parser.
        $crawler = new Crawler(null, $parser->link);
        $crawler->addHtmlContent($html, 'UTF-8');
        // Get title text.
        $content = [];

        $childNodesTasks = $crawler
            ->filter('body > section div.container > div.catalog-menu__scroller > div.row #tasks > div');

        $childNodesTask = $childNodesTasks->filter('div > div.row > div > a');
        foreach ($childNodesTask as $childNodesTitle){
            foreach($childNodesTitle->childNodes as $childNode){
                    if($childValue = trim($childNode->nodeValue)){
                        $content[] = str_replace(["\t","\r","\n", "\""],'',$childValue);
                    }
                }
            }
        return $content;
    }
}
