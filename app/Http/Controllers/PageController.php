<?php

namespace App\Http\Controllers;

use App\Models\Page;
use DB;
use Menu as LavMenu; //lavary/laravel-menu

class PageController extends Controller
{
    public function showPage(){

        $link = \Route::current()->uri();
//        dd($link);
        $id = DB::table('pages')->where('link','=', $link)->value('id');

        $arrMenu = DB::table('menu_page as m_p')->leftJoin('menus', 'm_p.menu_id', '=', 'menus.id')->where('page_id', $id)->get();
        $menu = $this->buildMenu($arrMenu);

        $page = Page::where('id', '=', $id)->firstOrFail();
        if($page->type == "junior_classes")
            return view('site.page_junior_classes', ['page' => $page, 'menu' => $menu]);
        return view('site.page_subject', ['page' => $page, 'menu' => $menu]);
    }
    /*
     * Формирование пунктов меню используя расширение
     * https://github.com/lavary/laravel-menu#installation
     */
    public function buildMenu ($arrMenu){
        return LavMenu::make('menu', function($menu) use ($arrMenu){
            foreach($arrMenu as $item){
                /*
                 * Для родительского пункта меню формируем элемент меню в корне
                 * и с помощью метода id присваиваем каждому пункту идентификатор
                 * создаёт роутер с помощью метода add()
                 */
                if($item->parent_id == 0){
                    /*
                     * Если в path ссылке есть символ #, то создаём линк на текущей странице
                     * Иначе делаем общий URL
                     */
                    if(str_contains($item->path, '#'))
                        $menu->add($item->title, $item->path)->id($item->id)->link->href($item->path);
                    else
                        $menu->add($item->title, $item->path)->id($item->id);
                }
                //иначе формируем дочерний пункт меню
                else {
                    //ищем для текущего дочернего пункта меню в объекте меню ($menu)
                    //id родительского пункта (из БД)
                    if($menu->find($item->parent_id)){
                        $menu->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });
    }
}

