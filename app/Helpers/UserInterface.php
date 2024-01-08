<?php

namespace App\Helpers;

use App\Helpers\Items\ItemsForCommon;
use App\Helpers\JoinSubjects as Subjects;
use App\Helpers\BattleFunction as BF;
use App\Models\ArtifactType;
use App\Models\ClassPerson;
use App\Models\ImageOfCharacter;
use App\Models\UserAction;
use App\Presenters\UserPresent;
use App\Helpers\Items\ItemsForProfile;
use App\User;
use App\Models\Mission;
use App\Models\Skill;
use App\Models\Slot;
use Illuminate\Database\Eloquent\Collection;
use function array_key_exists;

class UserInterface
{
    /**
     * Определяем свойство $lvl;
     * @var int $sum
     * @return integer
     * Функция конвертирует опыт ученика в уровень по заданной таблице
     * TODO: создать таблицу опыта и избавиться от if else
     * TODO: match в phpstorm не распознает
     * */
    public static function convertExpInLvl(int $sum): int
    {
        /**
        $lvl = match(true) {
            $sum >= 1000 && $sum < 2000 => 1,
            $sum >= 2000 && $sum < 3200 => 2,
            $sum >= 3200 && $sum < 4800 => 3,
            $sum >= 4800 && $sum < 7300 => 4,
            $sum >= 7300 && $sum < 12600 => 5,
            $sum >= 12600 && $sum < 20600 => 6,
            $sum >= 20600 && $sum < 25600 => 7,
            $sum >= 25600 && $sum < 34600 => 7,
            $sum >= 34600 && $sum < 48200 => 7,
            default => 0,
        };
          **/

        $lvl = 0;

        if ($sum >= 1000 && $sum < 2000) {
            $lvl = 1;
        } elseif ($sum >= 2000 && $sum < 3200) {
            $lvl = 2;
        } elseif ($sum >= 3200 && $sum < 4800) {
            $lvl = 3;
        } elseif ($sum >= 4800 && $sum < 7300) {
            $lvl = 4;
        } elseif ($sum >= 7300 && $sum < 12600) {
            $lvl = 5;
        }elseif ($sum >= 12600 && $sum < 20600) {
            $lvl = 6;
        }elseif ($sum >= 20600 && $sum < 25600) {
            $lvl = 7;
        }
        elseif ($sum >= 25600 && $sum < 34600) {
            $lvl = 8;
        }
        elseif ($sum >= 34600 && $sum < 48200) {
            $lvl = 9;
        }

        return $lvl;
    }

    /**
     * @var $user_id int
     * @return string
     * */
    public static function getSexUser(int $user_id): string
    {
        $sex = User::find($user_id)->sex;
        return ($sex == 'M') ? 'man' : 'woman';
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     * Функция собирает данные из таблицы images_of_characters и users_body
     * Выводит образы персонажей
     * Получаем список образов одного пользователя(связь BelongToMany)
     * TODO: Возможно, сделать смену образов и с выбором в интерфейсе.
     * *@var int $user_id
     */
    public static function getImageCharacter(int $user_id): Collection|\Illuminate\Support\Collection
    {

        $dir = static::getSexUser($user_id);
        $user = User::find($user_id);
        $image_char = $user->user_bodies()->get();

        //Если ещё нет образов, то привязываем к начальному образу
        if(!count($image_char)){
            $user->user_bodies()->attach(21, ['on' => 1]);
        }

        //Если образов больше чем 1, то удаляем начальный образ
        if(count($image_char) > 1 && $image_char->contains('id', '21')){
            $user->user_bodies()->detach(21);
        }

        return $image_char->map(function($item){
            //dd(collect($item)->on);
            //$item = $item->toArray();
            $item['on'] = $item->pivot->on;
            $item['canEquip'] = ['class_person_id' => $item['class_person_id'], 'sex' => $item['sex'], 'user_level' => $item['user_level']];
            return collect($item)->except(['pivot', 'id', 'class_person_id', 'user_level', 'sex']);
        });
    }

    /**
     * @var int $user_id
     * @return ImageOfCharacter
     * Выводит образ персонажа
     * Получаем выбранный образ образ
     * */
    public static function getActiveImageCharacter(int $user_id) : ImageOfCharacter {

        //Найти какой образ активен и отправить его
        $body = static::getImageCharacter($user_id);

        $idBodyActive = $body->search(function ($item) {
            return $item['on'] == 1;
        });

        return $body[$idBodyActive];
    }


    /**
     * @var int $user_id
     * @var UserPresent $user_present
     * @return array
     * Получаем список всех слотов с артефактами пользователя для составления инвентаря
     * */
    public static function getSlotsPerson(int $user_id, UserPresent $user_present): array{

        $slots = Slot::all();
        $preparedSlots = [];//Массив данных содержащий информацию о слотах и интерфейсе

        $bodies = static::getImageCharacter($user_id);

        //Получаем key образа установленный как активный
        $body = $bodies->search(function ($item){
            return $item['on'] === 1;
        });


        //Предметы экипированные на user
        $items = new ItemsForProfile($user_id, 1, $user_present, 'canEquip');
        $items_on = $items->getArtifacts();

        foreach($slots as $slot){

            $items = [];
            //Получаем предмет находящийся в slot->id
            $item_on = collect($items_on)->first(function ($item) use ($slot){
                return $item->slot_id === $slot->id;
            });

            if($item_on)
                $items[] = collect($item_on)->except(['rarity_id', 'artifact_type_id', 'artifact_trade_id', 'pivot', 'slot_id', 'subjects', 'price', 'image', 'user_level', 'class_type_id']);;//Чтобы убрать ссылку на родительский объект

            $s = [
                'active' => false,
                'images' => ['normal' => $slot->image_normal ?? "", 'arena' => $slot->image_arena ?? "", 'gold' => $slot->image_gold ?? ""],
                'items' => $items
            ];

            $slot_extended = (object)[...collect($slot)->except(['image_arena', 'image_arena', 'image_gold'])->toArray(), ...$s];

            array_push($preparedSlots, $slot_extended);
        }

        array_push($preparedSlots,
            (object)[
                    'id' => 13,
                    'name' => $bodies[$body]['name'] ,
                    'type'=> 13,
                    'images'=> (object)[
                        'info' => $bodies[$body]['image'],
                        'small'=> $bodies[$body]['image']
                ]
            ]);

        return $preparedSlots;
    }
    /**
     * @var int $user_id
     * @var string $subject
     * @return \Illuminate\Support\Collection
     * Получаем список всех квестов пользователя по id пользователя и alias предмета
     * */
    public static function getUserMissions(int $user_id, string $subject): \Illuminate\Support\Collection
    {
        return User::find($user_id)->user_missions()
            ->where('subject_id', Subjects::getSubjectId($subject))
            ->get()
            ->map(function ($item){
                $item->done = $item->pivot['done'];
                return $item->only(['id', 'name', 'description', 'progress_id', 'monster_id', 'user_level', 'done']);
            });
    }

    /**
     *
     * @param \Illuminate\Support\Collection $user_missions
     * @return array
     * Получаем список всех артефактов пользователя по миссиям пользователя
     */
    public static function getUserMissionsHtmlArtifacts(\Illuminate\Support\Collection $user_missions) : array
    {
        $missions_artifacts = [];

        foreach ($user_missions as $user_mission){
            $mission_artifacts = Mission::find($user_mission['id'])
                ->artifacts()
                ->get();

            if(!$mission_artifacts->isEmpty()){
                $items = new ItemsForCommon(null, $mission_artifacts);
                $missions_artifacts[] = collect($items->getArtifacts())->map(function ($item){
                    $item->mission_id = $item->pivot['mission_id'];
                    return collect($item)->only(['id','description', 'image', 'name', 'info', 'price', 'stats', 'mission_id']);
                });
            }
        }
        return $missions_artifacts;
    }

    /**
     * @var int $user_id
     * @return array
     * Получаем список всех артефактов, отфильрованных по наличию свойства increase_experience, increase_gold
     * */
    public static function getArtifactPersonFilteredForExpGold(int $user_id) : array
    {

        $artifacts = static::getArtifactsPerson($user_id);
        $arr = [];//Вспомогательный массив

        foreach ($artifacts as $artifact => $specifications) {

            //Массива содержит отфильтрованные характеристики отличные от 0 по experience и gold
            $filteredExpGoldArtifactSpec = [];

            foreach ($specifications as $specification => $value) {
                if ($specification == 'increase_experience' || $specification == 'increase_gold') {
                    if ($value) $filteredExpGoldArtifactSpec[$specification] = $value;
                }
            }

            $arr[] = $filteredExpGoldArtifactSpec;
        }

        return $arr;
    }

    /**
     *
     * @return \Illuminate\Support\Collection
     * Получаем выбранный класс одного пользователя(связь BelongToMany)
     * Done: в таблицу classes_person сделать поле active, чтобы указать текущий класс из множества принадлежащих user_id
     * Done: предполагается upgrade класса в несколько ступеней
     * Done: $user_class[0] заменить на $user_class[0]->where('active', 1): Done
     * @var int $user_id
     */
    public static function getUserClass(int $user_id) : \Illuminate\Support\Collection
    {
        $user_class = User::find($user_id)->classes_person()->where('active', '=', 1)->get();

        if(!$user_class){
            $user_class = ClassPerson::where('type_id', '=', '0')->first();
        }
        return $user_class;

    }
    /**
     * @var int $user_id
     * @var string $subject
     * @return \Illuminate\Support\Collection
     * Получаем список всех достижений пользователя по id пользователя и alias предмета
     * */
    public static function getUserProgress(int $user_id, string $subject): \Illuminate\Support\Collection
    {
        return User::find($user_id)->progresses()
            ->where('subject_id', Subjects::getSubjectId($subject))
            ->get()
            ->map(function ($item) {
                return $item->only(['name', 'type', 'rank' ,'description', 'image']);
            });
    }

    /**
     * @var int $user_id
     * @return Collection
     * Получаем список всех скиллов пользователя по id пользователя
     * */
    public static function getUserSkills(int $user_id): Collection
    {
        return static::getUserClass($user_id)->skills()->with(['features'])->get();
    }


    /**
     * @return \Illuminate\Support\Collection
     * Получаем список всех характеристик пользователя по id пользователя и alias предмета
     * *@var int $user_id
     */
    public static function getUserProperty(int $user_id): \Illuminate\Support\Collection
    {
        return static::updateUserProperty($user_id);
    }

    /**
     * @var int $user_id
     * @return \Illuminate\Support\Collection возвращает
     * Обновляет характеристики героя, при изменении экипировки
     * type_id свойсво тип выбираемого класса, меняется в property и user_class, у пользователя может быть несколько классов
     * Создаём чистые характиристики героя:
     * invariant_stats - начальные неизменяемые характеристики {}
     * artifact_stats - добвление характеристик от предметов {}
     * skill_stats - добвление характеристик от умений {}
     * up_level - добвление характеристик от уровня {}
     * total - итоговые характеристики {}
     * TODO::написать дополнительную функцию увеличения характеристик в зависомости от lvl->up_level и класс
     * TODO user_skills и user_actions как использовать при выборе
     */
    public static function updateUserProperty(int $user_id): \Illuminate\Support\Collection
    {

        $skills_actions = [];
        $artifact_stats = [];

        //Получаем инвариантные характеристики героя
        $user_class = collect(static::getUserClass($user_id)
            ->map(function ($item){
                //Убираем пересекающиеся свойства
                return collect($item)->except(['name', 'description', 'sex', 'id', 'pivot', 'type_id', 'image']);
            })
            ->first());

        //Создаём клон для сохранения начальных параметров
        $invariant_stats = clone $user_class;
        $user_class = $user_class->toArray();

        //Получаем все экипированные предметы
        $items = new ItemsForProfile($user_id, 1);
        $artifacts = $items->getArtifacts();

        //Добавление характеристик героя при использовании skills
        $actions = UserAction::whereUserId($user_id)->value('actions');
        $skills = json_decode($actions)->skills;

        foreach($skills as $skill){
            $skill_features = [];//Список расширений для одного skill
            $skill_model = Skill::find($skill->skill_id);
            $features = $skill_model->features()->get();
            $active = $skill->active;
            $number_of_moves = $skill->number_of_moves;

            //$features_list:
            // [
            //'1' => ['damage_min' => 1.1, 'damage_max' => 1.1, 'operator' => 'increase',  'method' => 'percent],
            //'2' => ['hp' => 50, 'operator' => 'decrease', 'method => 'absolute']
            //]
            $features_list = BF::FeatureStatsUser($features, $active, $number_of_moves);
            foreach ($features_list as $key=>$f_stats){
                $feature_stats = [];//Характиристики одного расширения
                foreach ($f_stats as $stat => $value) {
                    if ($stat == 'method' or $stat == 'operator')
                        continue;
                    if (collect($user_class)->has($stat) && $value) {

                        if ($f_stats['method'] != 'equally') {
                            //Уменьшение и увеличение в процентах отностельного или абсолютного текущего параметра
                            $stats_values = BF::FeatureRatioValue($value, $f_stats['operator'], $f_stats['method'], $user_class[$stat]);
                            $feature_stats[$stat] = round($stats_values['f_s']);
                            $user_class[$stat] = $stats_values['u_s'];
                        }

                        if (str_contains($stat, 'damage') && $f_stats['operator'] == 'max') {
                            $feature_stats['damage_max'] = $user_class['damage_max'];
                            $user_class['damage_min'] = $user_class['damage_max'];
                        }
                        if (str_contains($stat, 'damage') && $f_stats['operator'] == 'min') {
                            $feature_stats['damage_max'] = $user_class['damage_min'];
                            $user_class['damage_max'] = $user_class['damage_min'];
                        }
                    }
                }

                //Формируем объект skill
                foreach($skill_model->toArray() as $k => $value) {
                    if(($value && $k !== 'id') || $k == 'active')
                        $skill_features[$k] = $value;
                }

                $skill_features['stats'][$key] = $feature_stats;
            }

            $skills_actions[$skill->skill_id] = $skill_features;//Записываем все расширения для одного skill
        }

        //Добавление характеристик героя при надевании артифакта
        foreach($artifacts as $artifact){
            foreach ($artifact->stats as $stat => $value){
                if (collect($user_class)->has($stat) && $value){
                    if(array_key_exists($stat, $artifact_stats)){
                        $artifact_stats[$stat] += $value;
                    }else
                        $artifact_stats[$stat] = $value;

                    $user_class[$stat] += $value;
                }
            }
        }
        //$user_class['type_id'] так же обновляется при обновлении характеристик
        //type_id - это класса Маг или Воин или не выбран
        User::find($user_id)->property()->update($user_class);

        return collect([
            'invariant_stats' => $invariant_stats,
            'artifact_stats' => $artifact_stats,
            'skills_stats' => $skills_actions,
            'up_level' => [],
            'total' => User::find($user_id)->property()
                ->get()
                ->map(function ($item){
                    return collect($item)->except(['created_at', 'updated_at', 'user_id', 'id', 'type_id']);
                })
                ->first()
            ]);
    }

    /**
     * @param int $mission_id
     * @param string $subject
     * @return Collection
     * Получаем задачи из модели Task[Subject] по $mission_id, $subject
     */
    public static function getMissionTasks(int $mission_id, string $subject) : \Illuminate\Support\Collection {

        $_subject = Subjects::_Subject($subject);
        $tasks_function = 'task'.$_subject;
        $mission = Mission::find($mission_id);
        return $mission->$tasks_function()->orderBy('experience')->get()->values();
    }


    /**
     * @param int $user_id
     * @param string $subject
     * @return Collection
     * Получаем список процессов для разных моделей(связь hasMany)
     * Получаем задачи из модели Process_Subject c pivot task, выделяем только нужные поля
     * Поля: 'experience', 'gold', 'crystal' ,'rating', 'number_task', 'task', 'grade', 'subject', 'created_at'
     */
    public static function getLastTasks(int $user_id, string $subject) : \Illuminate\Support\Collection {

        //Метод hasMany для вызова моделей динамически для существующего предмета
        $process_func = 'processes_'.$subject;
        return User::find($user_id)->$process_func()
            ->with(['task'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($item) use ($subject) {
                $task = $item->task->only(['task', 'grade']);
                $item->task = $task['task'];
                $item->grade = $task['grade'];
                $item->subject = Subjects::getSubjectName($subject);
                return $item->only(['experience', 'gold', 'crystal' ,'rating', 'number_task', 'task', 'grade', 'subject', 'created_at']);
            })
            ->sortBy('number_task')
            ->reverse()
            ->values();
    }

    /**
     * @param int $user_id
     * @param string $subject
     * @return Collection
     * Получаем список процессов для разных моделей(связь hasMany)
     * Получаем статистику из модели Grade[Subject] и объединяем в одну коллекции
     */
    public static function getUserProcesses(int $user_id, string $subject) : \Illuminate\Support\Collection{
        $grade_func = 'grade_'.$subject;
        $grades = User::find($user_id)->$grade_func()->get();
        $stats = [];

        static::getStatsGrade($stats, $subject, $grades, $regroup=false, $group='');

        return collect($stats);
    }

    /**
     * @var $stats array
     * @var $subject string
     * @var $grades Collection
     * @var $regroup bool
     * @var $group string
     * @return void
     * Вспомогательная функция для получения статистики ученика
     * Используется рекурсия для более детальной обрабоки статистики
     * */
    public static function getStatsGrade(array &$stats ,string $subject, Collection $grades, bool $regroup, string $group) : void {


        $modelSections = 'App\Models\Sections'.ucfirst($subject);
        //Используемые свойства для получения по ним суммы всех элементов
        $props = ['sum_tasks', 'sum_exp', 'sum_gold'];
        //Используемые свойства для группировки по ним
        $propsGroup = ['number_lesson', 'grade_char', 'section_id'];
        //Счётчик для условия остановки рекурсии
        $count = 0;

        foreach ($propsGroup as $propGroup){

            if($propGroup == $group)
                continue;

            //Если счётчик равен длине основного массива для группировки по полям, то остановить рекурсию
            if(count($propsGroup) == $count)
                $regroup = false;

            foreach($grades->groupBy($propGroup) as $num => $grade){

                foreach ($props as $prop){

                    $sum = $grade->sum(function($item) use ($prop){
                        return $item->$prop;
                    });

                    //Вместо section_id вставляем название
                    if($propGroup == 'section_id'){
                        $section_name = $modelSections::find($num)->name;
                        $stats[$propGroup][$section_name][$prop] = round($sum, 2);
                    }else{
                        $stats[$propGroup][$num][$prop] = round($sum, 2);
                    }
                }

                //Условие для рекурсии $regroup булев тип, если false рекурсия вглубь уходить не будет
                if($regroup){
                    if($propGroup == 'section_id'){
                        $section_name = $modelSections::find($num)->name;
                        static::getStatsGrade($stats[$propGroup][$section_name], $subject, $grade, $regroup=false, $propGroup);
                    }else{
                        static::getStatsGrade($stats[$propGroup][$num], $subject, $grade, $regroup=false, $propGroup);
                    }
                    $regroup = true;
                }
            }

            $count++;
        }
    }

    /**
     * @param int $user_id
     * @param int $gold
     * @return int
     * Функция рассчитывает общее количество монет, учитывая покупки и продажи
     * */
    public static function updateGoldsUser(int $user_id, int $gold) : int {

        $userTransaction = User::find($user_id)->transactions()->get();

        if($userTransaction->count()){
            //Прибавляем к общей сумме
            $plusGold = $userTransaction->where('action','sale')->sum('gold');

            //Вычитаем из общей суммы
            $minusGold = $userTransaction->whereIn('action', ['buy', 'take'])->sum('gold');

            $gold = $gold + $plusGold - $minusGold;
        }

        return $gold;
    }

    /**
     * @param int $user_id
     * @param array $crystals
     * @return array
     * Функция рассчитывает общее количество кристаллов, учитывая покупки и продажи
     * */
    public static function updateArrayCrystalsUser(int $user_id, array $crystals) : array {

        $userTransaction = User::find($user_id)->transactions()->get();

        foreach ($crystals as $color_crystal => &$value){

            if($userTransaction->count() && $value > 0){
                //Прибавляем к общей сумме
                $plusCrystal = $userTransaction->where('action','sale')->sum($color_crystal);

                //Вычитаем из общей суммы
                $minusCrystal = $userTransaction->whereIn('action', ['buy', 'take'])->sum($color_crystal);

                $value = $value + $plusCrystal - $minusCrystal;
            }
        }

        unset($value);
        return $crystals;
    }

    /**
     * @var int $user_id
     * @return \Illuminate\Support\Collection
     * Функция собирает данные из таблицы trophy и user_trophy, rarity
     * Фильтрует массив от пустых значений и создает список характеристик трофеев
     * */
    public static function getArtifactsPerson(int $user_id): \Illuminate\Support\Collection
    {
        $items = new ItemsForCommon($user_id);
        return $items->getArtifacts();
    }

    /**
     * Функция получает объект типов артефактов ввиде artifact_type: {'weapon':'1', 'armor':'2', ...}
     * @return \Illuminate\Support\Collection
     **/
    public static function getArtifactTypes(): \Illuminate\Support\Collection {
        return ArtifactType::all()->where('active', 1)->pluck('dir', 'id')->flip();
    }

}