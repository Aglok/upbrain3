<?php

namespace App\Presenters;
use App\Helpers\JoinSubjects as Subjects;

class UserPresent extends Present
{
    /**
     * Переменная содержит массив свойств user_level, sum_res, stages
     **/
    protected array $subjects = [];
    /**
     * Суммарное ресурсов
     **/
    protected array $total_resources = [
        'gold' => 0,
        'red_crystal' => 0,
        'blue_crystal' => 0,
        'green_crystal' => 0,
        'yellow_crystal' => 0
    ];


    //Если $total_gold не задана, то по умолчанию задаётся 0
    public function __construct(array $subjects, float $total_gold = 0)
    {
        $this->setSubjectsProps($subjects, $total_gold);
    }

    /**
     * @param array $subjects
     * @param float $total_gold
     * Устанавливаем необходимые свойства gold, sum_res, stages, user_level
     * @return void
     **/
    public function setSubjectsProps(array $subjects, float $total_gold) : void {

        if($total_gold)
            $this->total_resources['gold'] = $total_gold;

        foreach ($subjects as $subject => $value){
            $this->subjects[$subject]['sum_res'] = $value['sum_res'];
            $this->subjects[$subject]['stages'] = $value['stages'];
            $this->subjects[$subject]['user_level'] = $value['user_level'];

            $color_crystal = Subjects::getSubjectColor($subject).'_crystal';
            $this->total_resources[$color_crystal] = $value['sum_res'][$color_crystal];
        }

    }

    //Функция выводит свойства привязанные к предметам
    public function getSubjectsProps() : array {
        return $this->subjects;
    }

    //Функция выводит общие ресурсы независимо от предметов
    public function getTotalResources(): array {
        return $this->total_resources;
    }

    //Получить массив ключей, alias предметов
    public function getArrayKeysSubjects(): array {
        return array_keys($this->subjects);
    }
}