<?php

namespace App\Helpers;

use App\Helpers\JoinSubjects as Subjects;
use App\Models\Artifact;
use App\Models\ImageOfCharacter;
use App\User;
use App\Models\Mission;
use App\Models\Slot;
use function dd;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class UserInterface
{
    /**
     * Определяем свойство $lvl;
     * @var $sum
     * @return integer
     * Функция конвертирует опыт ученика в уровень по заданной таблице
     * */
    public static function convertExpInLvl($sum): int
    {

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

    public static function getSexUser($user_id): string
    {
        
        $sex = User::find($user_id)->sex;

        if ($sex == 'M') {
            $dir = 'man';
        } else {
            $dir = 'woman';
        }

        return $dir;
    }

    /**
     * @var $user_id
     * @return array
     * Функция собирает данные из таблицы images_of_characters и users_body
     * Выводит образы персонажей
     * Получаем список образов одного пользователя(связь BelongToMany)
     * TODO: Возможно, сделать смену образов и с выбором в интерфейсе.
     * */
    public static function getImageCharacter($user_id): array
    {

        $dir = static::getSexUser($user_id);
        $image_char =  User::find($user_id)->user_bodies()->get();

        if(!count($image_char))
            $image_char[] = (object)['name' => 'Без образа', 'image' => '/images/items/characters/default/portal.png', 'pivot' => (object)['on' => 1]];

        return [$image_char, $dir];
    }

    /**
     * @var $user_id
     * @return ImageOfCharacter
     * Выводит образ персонажа
     * Получаем выбранный образ образ
     * */
    public static function getActiveImageCharacter($user_id){

        //Найти какой образ активен и отправить его
        $body = static::getImageCharacter($user_id)[0];

        $idBodyActive = $body->search(function ($item) {
            return $item->pivot->on == 1;
        });

        return $body[$idBodyActive];
    }

    /**
     * @var $user_id
     * @return \Illuminate\Support\Collection
     * Функция собирает данные из таблицы trophy и user_trophy, rarity
     * Фильтрует массив от пустых значений и создает список характеристик трофеев
     * */
    public static function getArtifactsPerson($user_id): \Illuminate\Support\Collection
    {
        $artifacts = User::find($user_id)->artifacts()->with('rarity', 'artifact_type')->get();


        //Генерируем html данные-свойства артефактов
        $filteredArtifactsSpecification = static::getArtifactsHtml($artifacts);

        return collect($filteredArtifactsSpecification);
    }

    /**
     * @var $user_id
     * @return array
     * Функция генерирует html данные-свойства артефактов ввиде ствойства info
     * Фильтрует массив от пустых значений и создает список характеристик трофеев
     * Создаём свойство stats ввиде набора характеристик артефакта
     * TODO::убрать class_person_id, increase_experience, increase_gold эти свойства определить в модели Feature
     * */
    public static function getArtifactsHtml($artifacts){

        $arr = [];//Вспомогательный массив содержит html обёртку по свойствам артефактов
        $stats = [];//Статистика по характеристикам

        //Преобразовывает коллекцию в массив для удобной итерации
        foreach ($artifacts->toArray() as $artifact) {

            $info = '<ul style="list-style: none">';
            $filteredArtifactSpecification = [];//Массива содержит отфильтрованные характеристики отличные от 0

                //Коллекцию переводим в массив для перебора значения
                foreach ($artifact as $specification => $value) {

                    if (!$value) continue;

                    $info .= '<li>';
                    if ($specification == 'name' || $specification == 'description') {
                        $info .= $value;
                    }elseif ($specification == 'attack') {
                        $stats[$specification] = $value;
                        $info .= 'атака: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'damage') {
                        $stats[$specification] = $value;
                        $info .= 'урон: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'shield') {
                        $stats[$specification] = $value;
                        $info .= 'защита: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'hp') {
                        $stats[$specification] = $value;
                        $info .= 'здоровье: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'mp') {
                        $stats[$specification] = $value;
                        $info .= 'магия: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'energy') {
                        $stats[$specification] = $value;
                        $info .= 'энергия: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'critical_damage') {
                        $stats[$specification] = $value;
                        $info .= 'Критический урон: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'energy') {
                        $stats[$specification] = $value;
                        $info .= 'Вероятность кр. урон: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'increase_experience') {
                        $stats[$specification] = $value;
                        $info .= 'увл. опыта: ' . ($value * 100) . '%';
                        unset($specification);
                    }elseif ($specification == 'increase_gold') {
                        $stats[$specification] = $value;
                        $info .= 'увл. золота: ' . ($value * 100) . '%';
                        unset($specification);
                    }elseif ($specification == 'rarity') {
                        $info .= 'редкость: ' . $value['name'];
                    }elseif ($specification == 'weight') {
                        $stats[$specification] = $value;
                        $info .= 'вес: ' . $value;
                        unset($specification);
                    }elseif ($specification == 'artifact_type_id') {
                        unset($specification);
                    }elseif ($specification == 'rarity_id') {
                        unset($specification);
                    }

                    $info .= '</li>';

                    if(isset($specification))
                        $filteredArtifactSpecification[$specification] = $value;

                    $filteredArtifactSpecification['images'] = (object)[
                            'off' => '',
                            'info' => $artifact['image'],
                            'on' => ''
                    ];

                    //Удаляем так как мы сделали новые переменные images
                    unset($filteredArtifactSpecification['image']);

                }
            $info .= '</ul>';

            //Удаляем пустые списки <li></li>
            $info = str_replace("<li></li>", "", $info);

            $filteredArtifactSpecification['info'] = $info;
            $filteredArtifactSpecification['stats'] = (object)$stats;

            array_push($arr, (object)$filteredArtifactSpecification);
        }

        return $arr;
    }

    /**
     * @var int $user_id
     * @var int $equip неэкипирован/экипирован 0/1
     * @return \Illuminate\Support\Collection
     * Получаем список всех артефактов неэкипированых или экипированых 0/1
     * */
    public static function getItemsPerson($user_id, $equip = 0){

        $equip = (int)$equip;
        $artifacts = static::getArtifactsPerson($user_id);

        $filteredArtifacts =  $artifacts->filter(function ($value) use ($equip) {
            if(array_key_exists('pivot', (array)$value))
                return $value->pivot['equip'] === $equip;
        })->values();

        return $filteredArtifacts;
    }

    /**
     * @var $user_id
     * @return array
     * Получаем список всех слотов с артефактами пользователя для составления инвентаря
     * */
    public static function getSlotsPerson($user_id){

        $slots = Slot::all();
        $preparedSlots = [];//Массив данных содержащий информацию о слотах и интерфейсе

        $bodies = static::getImageCharacter($user_id)[0];

        //Получаем key образа установленный как активный
        $body = $bodies->search(function ($item, $key){
            return $item->pivot->on === 1;
        });


        //Предметы экипированные на user
        $items_on = static::getItemsPerson($user_id, 1);

        foreach($slots as $slot){

            $items = [];

            //Получаем key предмета находящийся в slot->id
            $item_on = $items_on->search(function ($item) use ($slot){
                return $item->slot_id === $slot->id;
            });

            if($item_on === 0 || $item_on)
                $items[] = $items_on[$item_on];//Чтобы убрать ссылку на родительский объект

            $s = (object)array_merge($slot->toArray(),
                [
                    'active' => false,
                    'images' => ['normal' => $slot->image_normal, 'arena' => $slot->image_arena, 'gold' => $slot->image_gold],
                    'items' => $items
                ]);

            array_push($preparedSlots, $s);
        }

        array_push($preparedSlots,
            (object)
                [
                    'id' => 13,
                    'name' => $bodies[$body]->name ,
                    'type'=> 13,
                    'images'=> (object)[
                        'info' => $bodies[$body]->image,
                        'small'=> $bodies[$body]->image
                ]
            ]);

        return $preparedSlots;
    }
    /**
     * @var $user_id
     * @var $subject_id
     * @return Collection
     * Получаем список всех квестов пользователя по id пользователя и alias предмета
     * */
    public static function getUserMissions($user_id, $subject)
    {
        return User::find($user_id)->user_missions()->where('subject_id', Subjects::getSubjectId($subject))->get();
    }

    /**
     * @var $user_missions
     * @return array
     * Получаем список всех артефактов из массива квестов, к каждому квесту привязан свой предмет
     * */
    public static function getUserMissionsHtmlArtifacts($user_missions)
    {
        $missions_artifacts = [];

        foreach ($user_missions as $user_mission){
            $mission_artifacts = Mission::find($user_mission->id)->artifacts()->get();

            if(!$mission_artifacts->isEmpty()){
                $missions_artifacts[] = static::getArtifactsHtml($mission_artifacts);
            }
        }

        return $missions_artifacts;
    }

    public static function getArtifactPersonFilteredForExpGold($user_id)
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

            array_push($arr, $filteredExpGoldArtifactSpec);
        }

        return $arr;
    }

    /**
     * @var $user_id
     * @return Collection | String
     * Получаем список классов одного пользователя(связь BelongToMany)
     * TODO: в таблицу classes_person сделать поле active, чтобы указать текущий класс из множества принадлежащих user_id
     * TODO: предполагается upgrade класса в несколько ступеней
     * TODO: $user_class[0] заменить на $user_class[0]->where('active', 1)
     * */
    public static function getUserClass($user_id)
    {
        $user_class = User::find($user_id)->classes_person()->get();

        return (count($user_class) ? $user_class[0]: "Класс героя не выбран");

    }
    /**
     * @var $user_id
     * @var $subject
     * @return Collection
     * Получаем список всех достижений пользователя по id пользователя и alias предмета
     * */
    public static function getUserProgress($user_id, $subject)
    {
        return User::find($user_id)->progresses()->where('subject_id', Subjects::getSubjectId($subject))->get();
    }

    /**
     * @var $user_id
     * @return object
     * Получаем список всех достижений пользователя по id пользователя и alias предмета
     * */
    public static function getUserProperty($user_id)
    {
        static::updateUserProperty($user_id);
        return User::find($user_id)->property()->first();
    }

    /**
     * @var $user_id
     * @return void
     * Обновляет характеристики героя, при изменении экипировки
     * TODO::написать дополнительную функцию увеличения характеристик в зависомости от lvl и класса
     * */
    public static function updateUserProperty($user_id){

        //Получаем инвариантные характеристики героя
        $user_class = static::getUserClass($user_id)->toArray();

        //Убираем пересекающиеся свойства
        unset($user_class['id']);
        unset($user_class['name']);
        unset($user_class['description']);
        unset($user_class['image']);
        unset($user_class['pivot']);
        unset($user_class['sex']);

        //Получаем все экипированные предметы
        $artifacts = static::getItemsPerson($user_id, 1);

        foreach($artifacts as $artifact){
            foreach ($artifact->stats as $stat => $value){
                if (array_key_exists($stat, $user_class) && $value){
                    $user_class[$stat] += $value;
                }

            }
        }

        User::find($user_id)->property()->update($user_class);
    }

    /**
     * @var $subject
     * @var $user_id
     * @return Collection
     * Получаем список процессов для разных моделей(связь hasMany)
     * Получаем задачи из модели Task[Subject] и объединяем в одну коллекции
     * */
    public static function getLastTasks($subject, $user_id){

        $process_func = 'processes_'.$subject;//Метод hasMany для вызова моделей динамически для существующего предмета
        $modelTask = 'App\Models\Task'.ucfirst($subject);
        $processes = User::find($user_id)->$process_func()->latest()->limit(10)->get()->reverse();
        $arrayNumbers = $processes->pluck('number_task');

        $tasks = $modelTask::whereIn('number_task', $arrayNumbers)->get()->toArray();

        $tasksObject = collect([]);

        foreach($processes->toArray() as $key => $process){
            //Объединение массивов происходит заменой одинаковых полей первого, на второй массив
            //Добавляем свойство show для раскрытия/закрытия tooltip на странице
            $tasksObject->push((object)array_merge($tasks[$key], $process, ['show' => false, 'subject' => Subjects::getSubjectName($subject)]));
        }

        return $tasksObject;
    }

    /**
     * @var $subject
     * @var $user_id
     * @return Collection
     * Получаем список процессов для разных моделей(связь hasMany)
     * Получаем статистику из модели Grade[Subject] и объединяем в одну коллекции
     * */
    public static function getUserProcesses($subject, $user_id){
        $grade_func = 'grade_'.$subject;
        $grades = User::find($user_id)->$grade_func()->get();
        $stats = [];

        static::getStatsGrade($stats, $subject, $grades, $regroup=false, $group='');

        return collect($stats);
    }

    /**
     * @var $stats array
     * @var $subject string
     * @var $grades array
     * @var $regroup bool
     * @var $group string
     * Вспомогательная функция для получения статистики ученика
     * Используется рекурсия для более детальной обрабоки статистики
     * */
    public static function getStatsGrade(array &$stats ,$subject, $grades, $regroup, $group){


        $modelSections = 'App\Models\Sections'.ucfirst($subject);
        //Используемые свойства для получения по ним суммы всех элементов
        $props = ['sum_tasks', 'sum_exp', 'sum_gold'];
        //Используемые свойства для группирровки по ним
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
                        $stats[$propGroup][$section_name][$prop] = $sum;
                    }else{
                        $stats[$propGroup][$num][$prop] = $sum;
                    }
                }

                // Условие для рекурсии $regroup булев тип, если false рекурсия вглубь уходить не будет
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
}