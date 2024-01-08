<?php


namespace App\Helpers\Items;

use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\Presenters\ArtifactPresent;
use App\Presenters\UserPresent;
abstract class Items
{
    protected $artifacts;
    protected $user;

    public function __construct(int $user_id)
    {
        $user = User::find($user_id);
        //Уставновить спискок артефактов ученика
        $this->setArtifacts($user);
        $this->user = $user;
    }

    public abstract function getItems(User $user): Collection;
    public abstract function getFilteredItems(): Collection;

    /**
     * @param $artifacts Collection
     * @param UserPresent|null $user_present
     * @param null $can
     * @param callable|null $callback примает вывод $artifact ожидается артефакт со свойствами
     * @return Collection Функция принимает артефакты из магазина и проверяет на условия возможности покупки и добавляет свойство canBay
     * Функция принимает артефакты из магазина и проверяет на условия возможности покупки и добавляет свойство canBay
     */
    public function getItemsWithCan(Collection $artifacts, UserPresent $user_present = null , $can = null, callable $callback = null): Collection{

        //Если не заданы параметры $user_present и $can, то вызращаем без дополнительного свойства $can
        if(!$user_present || !$can){
            return $artifacts;
        }

        //Массив предметов содержащий user_level, stages, sum_res
        $subjects_props = $user_present->getSubjectsProps();
        //Массив ресурсов
        $total_resources = $user_present->getTotalResources();

        $artifacts->each(function ($artifact, $key) use ($total_resources, $subjects_props, $can, $callback) {

            //Вызваем для перепределения объекта, ожидается артефакт со свойствами
            if($callback){
                $artifact = $callback($artifact);
            }

            $artifactPresent = new ArtifactPresent($artifact);

            //Динамическое создание свойства canBuy/canEquip
            $artifact->{$can} = $artifactPresent->limitedConditions($this->user, $total_resources, $subjects_props, $can);
        });

        return $artifacts;
    }


    /**
     * @param  $artifacts Collection
     * @param  callable|null  $callback
     * @return array
     * Функция генерирует html данные-свойства артефактов ввиде ствойства info
     * Фильтрует массив от пустых значений и создает список характеристик трофеев
     * Создаём свойство stats ввиде набора характеристик артефакта
     * TODO::убрать class_person_id, increase_experience, increase_gold эти свойства определить в модели Feature
     * */
    public function getArtifactsHtml(Collection $artifacts, callable $callback = null) : array{

        $arr = [];//Вспомогательный массив содержит html обёртку по свойствам артефактов

        //Преобразовывает коллекцию в массив для удобной итерации
        foreach ($artifacts as $artifact) {

            if($callback){
                $artifact = $callback($artifact);
            }

            $artifact = new ArtifactPresent($artifact);

            //Массива содержит отфильтрованные характеристики отличные от 0
            $filteredArtifactSpecification = [];

            //Получаем скомпанованные свойства
            $filteredArtifactSpecification['info'] = $artifact->infoHtml();
            $filteredArtifactSpecification['stats'] = $artifact->stats();
            $filteredArtifactSpecification['images'] = $artifact->images();

            //Коллекцию переводим в массив для перебора значения
            foreach ($artifact->toArray() as $specification => $value) {

                if ($specification == 'canBuy' || $specification == 'canEquip' || $specification == 'quantity'){
                    $filteredArtifactSpecification[$specification] = $value;
                }

                if(!$value) continue;

                //Удаляем лишние характеристики совпадающие со значениями в stats
                if(isset($artifact->stats()->{$specification})){
                    unset($specification);
                }

                if(isset($specification))
                    $filteredArtifactSpecification[$specification] = $value;

            }
            array_push($arr, (object)$filteredArtifactSpecification);
        }

        return $arr;
    }

    //Уставновить спискок артефактов ученика
    public function setArtifacts($user){
        $this->artifacts = $this->getItems($user);
    }

    //Получить спискок артефактов
    public function getArtifacts(){
        return $this->artifacts;
    }


}