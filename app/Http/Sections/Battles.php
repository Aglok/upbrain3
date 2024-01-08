<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminColumnEditable;
use App\User;
use Exception;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Section;
use AdminDisplayFilter;

/**
 * Class Battles
 *
 * @property \App\Models\Battle $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Battles extends Section
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;


    /**
     * @param array $payload
     *
     * @return DisplayInterface
     * @throws Exception
     */
    public function onDisplay(array $payload = []): DisplayInterface
    {
        $columns = [
            //AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('user.full_name', 'Ученик', 'created_at')->append(AdminColumn::filter('user_id'))
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('created_at', 'like', '%'.$search.'%');
                })->setOrderable(function($query, $direction) {
                    $query->orderBy('created_at', $direction);
                })
            ,
            AdminColumnEditable::text('monster.name', 'Монстер'),
            AdminColumnEditable::text('win', 'Результат')->setModifier(function ($element) {
                if(!is_null($element->getModelValue()))
                    return ($element->getModelValue()) ? 'Победа' : 'Поражение' ;
            }),
            AdminColumn::text('time', 'Время битвы (секунды)'),
            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
                ->setWidth('160px')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('updated_at', $direction);
                })
                ->setSearchable(false)
            ,
            AdminColumn::lists('actions.name', 'Действия')
        ];

        $display = AdminDisplay::datatables()
            ->setName('datatables')
            ->with(['user', 'monster', 'actions'])
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-bordered table-success table-hover');


        $display->setFilters([
            AdminDisplayFilter::related('user_id')->setModel(User::class)->setTitle(function($id){
                return User::find($id)->full_name;
            })
        ]);

        $display->setColumnFilters([
            AdminColumnFilter::select(User::class, 'full_name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query->where('active', 1);
                })
                ->setColumnName('user_id')
                ->setPlaceholder('Все')
        ]);
        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

}
