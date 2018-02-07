<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $widgets = [
       // \App\Widgets\DashboardMap::class,
        \App\Widgets\NavigationNotifications::class,
        \App\Widgets\NavigationUserBlock::class
    ];
    protected $sections = [
        \App\User::class => 'App\Http\Sections\Users',
        \App\Role::class => 'App\Http\Sections\Roles',
        \App\Models\Artifact_Type::class => 'App\Http\Sections\Artifact_Type',
        \App\Models\Artifact::class => 'App\Http\Sections\Artifact',
        \App\Models\Category_Subject_Physics::class => 'App\Http\Sections\Category_Subject_Physics',
        \App\Models\Category_Subject::class => 'App\Http\Sections\Category_Subject',
        \App\Models\Class_Person::class => 'App\Http\Sections\Class_Person',
        \App\Models\Game_Duel::class => 'App\Http\Sections\Game_Duel',
        \App\Models\Grade_Physics::class => 'App\Http\Sections\Grade_Physics',
        \App\Models\Grade::class => 'App\Http\Sections\Grade',
        \App\Models\Image_Of_Character::class => 'App\Http\Sections\Image_Of_Character',
        \App\Models\Menu::class => 'App\Http\Sections\Menu',
        \App\Models\Message::class => 'App\Http\Sections\Message',
        \App\Models\Mission::class => 'App\Http\Sections\Mission',
        \App\Models\Newsletter_User::class => 'App\Http\Sections\Newsletter_User',
        \App\Models\Newsletter::class => 'App\Http\Sections\Newsletter',
        \App\Models\Page::class => 'App\Http\Sections\Pages',
        \App\Models\Post::class => 'App\Http\Sections\Post',
        \App\Models\Process_Physics::class => 'App\Http\Sections\Process_Physics',
        \App\Models\Process::class => 'App\Http\Sections\Process',
        \App\Models\Progress::class => 'App\Http\Sections\Progress',
        \App\Models\Rarity::class => 'App\Http\Sections\Rarity',
        \App\Models\Set_Of_Task_Physics::class => 'App\Http\Sections\Set_Of_Task_Physics',
        \App\Models\Set_Of_Task::class => 'App\Http\Sections\Set_Of_Task',
        \App\Models\Set_Of_Task_Type::class => 'App\Http\Sections\Set_Of_Task_Type',
        \App\Models\Stage::class => 'App\Http\Sections\Stage',
        \App\Models\Subject_Physics::class => 'App\Http\Sections\Subject_Physics',
        \App\Models\Subject::class => 'App\Http\Sections\Subject',
        \App\Models\Tag::class => 'App\Http\Sections\Tag',
        \App\Models\Task_Physics::class => 'App\Http\Sections\Task_Physics',
        \App\Models\Task::class => 'App\Http\Sections\Task',
        \App\Models\Trophy_Type::class => 'App\Http\Sections\Trophy_Type',
        \App\Models\Trophy::class => 'App\Http\Sections\Trophy',
        \App\Models\User_Artifact::class => 'App\Http\Sections\User_Artifact',
        \App\Models\User_Body::class => 'App\Http\Sections\User_Body',
        \App\Models\User_Class::class => 'App\Http\Sections\User_Class',
        \App\Models\User_Mission::class => 'App\Http\Sections\User_Mission',
        \App\Models\User_Progress::class => 'App\Http\Sections\User_Progress',
        \App\Models\User_Trophy::class => 'App\Http\Sections\User_Trophy',
    ];

    /**
     * Register sections.
     *
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        parent::boot($admin);
        $this->app->call([$this, 'registerViews']);
    }

    /**
     * @param WidgetsRegistryInterface $widgetsRegistry
     */
    public function registerViews(WidgetsRegistryInterface $widgetsRegistry)
    {
        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }
}
