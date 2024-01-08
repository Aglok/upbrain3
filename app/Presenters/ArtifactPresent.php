<?php

namespace App\Presenters;

use App\Models\ClassPerson;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class ArtifactPresent extends Present
{
    /**
     * Необходимые характеристики для артефакта
     **/
    public array $translateStats = [
        'attack' => 'атака',
        'damage_min' => 'Мин. урон',
        'damage_max' => 'Макс. урон',
        'shield' => 'защита',
        'hp' => 'здоровье',
        'mp' => 'магия',
        'energy' => 'энергия',
        'critical_damage' => 'критический урон',
        'critical_chance' => 'вероятность кр. урон',
        'increase_experience' => 'увл. опыта',
        'increase_gold' => 'увл. золота',
        'weight' => 'вес'
    ];

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * Добавим свойство images для артефакта и удалим лишнее свойство image
     **/
    public function images(): stdClass
    {

        //unset($this->model->image);
        return (object)[
            'upgrade' => '',
            'info' => $this->model->image,
            'skin' => ''
        ];
    }

    /**
     * Добавим свойство infoHtml для артефакта, выводит html список характеристик
     **/
    public function infoHtml(): array|string
    {

        $info = '<ul style="list-style: none">';

        //Коллекцию переводим в массив для перебора значения
        foreach ($this->model->toArray() as $specification => $value) {

            if (!$value) continue;

            $info .= '<li>';

            //Проверяем содержатся ли перебираемые свойства в подготовленном массиве $this->translateStats
            if (array_key_exists($specification, $this->translateStats)) {
                $info .= $this->translateStats[$specification] . ': ' . $value;
            }

            $info .= '</li>';
        }

        $info .= '</ul>';

        //Удаляем пустые списки <li></li>
        return str_replace("<li></li>", "", $info);

    }

    /**
     * Добавим свойство stats для артефакта, объект необходимых характеристик
     * "@return object
     **/
    public function stats(): object
    {
        //Статистика по характеристикам
        $stats = [];

        //Коллекцию переводим в массив для перебора значения
        foreach ($this->model->toArray() as $specification => $value) {

            if (!$value) continue;

            //Проверяем содержатся ли перебираемые свойства в подготовленном массиве $this->translateStats
            if (array_key_exists($specification, $this->translateStats)) {
                $stats[$specification] = $value;
                unset($specification);
            }

        }

        return (object)$stats;
    }

    /**
     * @param User $user
     * @param array $total_resources
     * @param array subjects_props, переменная содержит массив свойств user_level, sum_res, stages
     * @param string $can
     * @return object
     * Функция добавляет свойство canBay/canEquip к артефакту
     * */
    public function limitedConditions(User $user, array $total_resources, array $subjects_props, string $can): object
    {
        $array = [];

        //Для окна покупки
        if ($can == 'canBuy') {
            //Определяем какая сумма денег нужна для покупки артефакта
            $need_resources = $this->needResources($total_resources);

            //Массив разных ресурсов gold, red_crystal, blue_crystal, green_crystal, yellow_crystal
            if (array_sum(array_values($need_resources)) > 0)
                $array['different_cost'] = (object)$need_resources;
        }
        //Для окна экипировки
        if ($can == 'canEquip') {

            //Если массив необходимых достижений не пустой, делаем запись
            if ($this->needProgresses($user)->isNotEmpty())
                $array['progresses'] = $this->needProgresses($user)->pluck('name');

            //Определяем необходимый уровень
            $need_level = $this->needLevel($subjects_props);

            if (count($need_level) > 0)
                $array['level'] = $need_level;

            //Если пользователь уже получил класс, то разрешается одеть предмет
            $need_class_type = $this->needClassType($this->model->class_type_id, $user);
            if ($need_class_type)
                $array['class_type'] = $need_class_type;
        }

        //Динамическое создание свойства canBuy
        return (object)$array;
    }

    /**
     * @param array $total_resources
     * @return array
     * Функция определяем какая сумма денег нужна для покупки артефакта
     * */
    public function needResources(array $total_resources): array
    {

        //Массив содержащий разницу необходимую для покупки артефакта
        $need_resources = [];
        $need_resource = 0;
        foreach ($total_resources as $resource => $value) {


            //Если свойство существует, то необходимо сравнить с ресурсами стоимостью артефакта
            //Если, хватает, то выводим 0, если нет, но выводим разницу
            $artifact_trade = $this->model->artifact_trade;
            if (collect($artifact_trade)->has($resource)) {
                $need_resource = ($value >= $artifact_trade->{$resource}) ? 0 : abs($value - $artifact_trade->{$resource});
            }

            if ($need_resource > 0)
                $need_resources[$resource] = $need_resource;
        }
        return $need_resources;
    }

    /**
     * @param User $user
     * @return Collection
     * Функция определяем какие достижения нужны для покупки артефакта
     * */
    public function needProgresses(User $user): Collection
    {

        $user_progresses = $user->progresses()->get();
        $artifact_progresses = $this->model->progresses()->get();
        return $artifact_progresses->diff($user_progresses);
    }

    /**
     * @param array $subjects_props
     * @return array
     * Функция определяем какие уровни нужны для покупки артефакта
     * */
    public function needLevel(array $subjects_props): array
    {

        $need_levels = [];
        $subjects = $this->model->subjects->map(function ($item) {
            //Убираем пересекающиеся свойства
            $item['user_level'] = $item->pivot->user_level;
            return collect($item)->only(['alias', 'user_level']);
        });

        //Определяем необходимый уровень
        foreach ($subjects as $subject) {
            //dd($props['user_level']);
            $need_level = 0;
            $alias = $subject['alias'];//Алиас предмета

            if (collect($subjects_props)->has($alias)) {
                $props = $subjects_props[$alias];//Получаем общие свойсва по алиасу

                //Если ли у артефакта задана зависимость от предмета, то её запишем, иначе проигнорируем
                if (collect($props)->has('user_level'))
                    $need_level = ($props['user_level'] >= $subject['user_level']) ? 0 : $subject['user_level'];
            }

            //Если такого предмета у ученика нет, проверка производиться не будет, сразу запишется как условие
            if (!collect($subjects_props)->has($alias)) {
                $need_level = $subject['user_level'];
            }

            if ($need_level)
                $need_levels[$alias] = $need_level;
        }

        return $need_levels;
    }

    /**
     * @param User $user
     * @param int $class_type_id
     * @return string
     * Функция определяет какие классы нужны для покупки/надеть артефакта
     * $class_type_id = 1 это все классы и проверка дополнително не нужна, так как ClassPerson не содержит такой тип
     */
    public function needClassType(int $class_type_id, User $user): string
    {
        $need_type_class = '';
        $user_classes = $user->classes_person()->get();

        if (!$user_classes->contains('type_id', $class_type_id)) {
            $class_person = ClassPerson::where('type_id', $class_type_id)->where('sex', $user->sex)->first();
            if ($class_person)
                $need_type_class = $class_person->name;
        }

        return $need_type_class;
    }

}