<?php

use App\Models\Action;
use App\Models\Artifact;
use App\Models\ArtifactTrade;
use App\Models\ArtifactType;
use App\Models\Battle;
use App\Models\CategoryMath;
use App\Models\CategoryPhysics;
use App\Models\ClassPerson;
use App\Models\Contact;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamSubject;
use App\Models\Feature;
use App\Models\ImageOfCharacter;
use App\Models\Mission;
use App\Models\Monster;
use App\Models\Post;
use App\Models\ProcessPhysics;
use App\Models\Progress;
use App\Models\Rarity;
use App\Models\School;
use App\Models\SectionsMath;
use App\Models\SectionsPhysics;
use App\Models\SetOfTaskMath;
use App\Models\SetOfTaskPhysics;
use App\Models\ShopItem;
use App\Models\Skill;
use App\Models\Stage;
use App\Models\TaskMath;
use App\Models\TaskPhysics;
use App\Models\UserAction;
use App\Models\UserArtifact;
use App\Models\UserBody;
use App\Models\UserClass;
use App\Models\UserMission;
use App\Models\UserTransaction;
use SleepingOwl\Admin\Navigation\Page;

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
// 	   return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\User::class)->setTitle('test')->setPages(function(Page $page) {
// 	  $page
//		  ->addPage()
//	  	  ->setTitle('Dashboard')
//		  ->setUrl(route('admin.dashboard'))
//		  ->setPriority(100);
//
//	  $page->addPage(\App\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\User::class)

return [
//    [
//        'title' => 'Dashboard',
//        'icon'  => 'fa fa-dashboard',
//        'url'   => route('admin.dashboard'),
//    ],
//
//    [
//        'title' => 'Information',
//        'icon'  => 'fa fa-exclamation-circle',
//        'url'   => route('admin.information'),
//    ],
    [
        'title' => 'Статистика',
        'icon' => 'fa fa-bar-chart',
        'priority' =>'1',
        'pages' => [
            [
                'title' => 'Статистика учеников М',
                'icon'  => '',
                'url'   => 'admin/users_table/math',
                'priority' =>'1'
            ],
            [
                'title' => 'Статистика учеников Ф',
                'icon'  => '',
                'url'   => 'admin/users_table/physics',
                'priority' =>'2'
            ]
        ],
    ],
    [
        'id' => 'battle',
        'title' => 'Битва',
        'icon' => 'fa fa-id-card',
        'priority' =>'2',
        'pages' => [
            (new Page(Battle::class))
                ->setTitle('Лог битвы')
                ->setPriority(1)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(Action::class))
                ->setTitle('Действия')
                ->setPriority(2)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(Monster::class))
                ->setTitle('Монстры')
                ->setPriority(3)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(Skill::class))
                ->setTitle('Навыки')
                ->setPriority(4)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(UserAction::class))
                ->setTitle('Действия игрока')
                ->setPriority(5)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();})
        ]
    ],
    [
        'title' => 'Интерфейс',
        'icon' => 'fa fa-id-card',
        'priority' =>'3',
        'pages' => [
            
            //2 уровень Создать задания
/*            [
                'title' => 'Создать задания',
                'url'   => route('list_missions'),
                'priority' =>'1'
            ],*/
            (new Page(Mission::class))
                ->setTitle('Создать задания')
                ->setPriority(1)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(UserMission::class))
                ->setTitle('Задания учеников')
                ->setPriority(2)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(ImageOfCharacter::class))
                ->setTitle('Создать образ')
                ->setPriority(3)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(UserBody::class))
                ->setTitle('Образы учеников')
                ->setPriority(4)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),

            //3 уровень - Артефакты
            [
                'title' => 'Артефакты',
                'priority' =>'5',
                'pages' => [
                    (new Page(Artifact::class))
                        ->setTitle('Создать артефакт')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(1),
                    (new Page(ArtifactTrade::class))
                        ->setTitle('Стоимость артефакта')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(2),
                    (new Page(Feature::class))
                        ->setTitle('Расширения')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(3),
                    (new Page(ArtifactType::class))
                        ->setTitle('Тип артeфакта')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(4)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(UserArtifact::class))
                        ->setTitle('Артeфакты учеников')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(5)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(Rarity::class))
                        ->setTitle('Редкость')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(6)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(ShopItem::class))
                        ->setTitle('Магазин')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(7)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                ],
            ],
            (new Page(ClassPerson::class))
                ->setTitle('Создать классы')
                ->setPriority(5),
            (new Page(UserClass::class))
                ->setTitle('Классы учеников')
                ->setPriority(6),

        ]

    ],
    [
        'title' => 'Задачи',
        'icon' => 'fa fa-book',
        'priority' =>'4',
        'pages' => [

            //2 уровень Управление задачами
            //Математика
            [
                'title' => 'Математика',
                'icon' => '',
                'priority' =>'1',
                'pages' => [

                    //3 уровень Математика

                    (new Page(CategoryMath::class))
                        ->setTitle('Разделы')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(1),
                    (new Page(SectionsMath::class))
                        ->setTitle('Темы')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(2),
                    (new Page(TaskMath::class))
                        ->setTitle('Задачи')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(3),
                    (new Page(SetOfTaskMath::class))
                        ->setTitle('Набор задач')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(4),
                ]
            ],

            //Физика
            [
                'title' => 'Физика',
                'icon' => '',
                'priority' =>'2',
                'pages' => [

                    //3 уровень Физика

                    (new Page(CategoryPhysics::class))
                        ->setTitle('Разделы')
                        ->setPriority(1)
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(SectionsPhysics::class))
                        ->setTitle('Темы')
                        ->setPriority(2)
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(TaskPhysics::class))
                        ->setTitle('Задачи')
                        ->setPriority(3)
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(SetOfTaskPhysics::class))
                        ->setTitle('Набор задач')
                        ->setPriority(4)
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                ]
            ],
            (new Page(Stage::class))
                ->setTitle('Этапы')
                ->setPriority(3)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(Progress::class))
                ->setTitle('Достижения')
                ->setPriority(4)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            [
                'title' => 'Импорт',
                'icon' => '',
                'priority' =>'5',
                'url' => route('import')
            ]

        ]
    ],
    [
        'title' => 'Создать страницы',
        'icon' => 'fa fa-pencil-square',
        'priority' =>'5',
        'pages' => [
            (new Page(\App\Models\Page::class))
                ->setTitle('Страницы')
                ->setPriority(0)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\Menu::class))
                ->setTitle('Меню')
                ->setPriority(1)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(Post::class))
                ->setTitle('Посты')
                ->setPriority(2)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(School::class))
                ->setTitle('Школы')
                ->setPriority(3)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\Tag::class))
                ->setTitle('Теги')
                ->setPriority(4)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();})
        ]
    ],
    [
        'title' => 'Процесс обучения',
        'icon' => 'fa fa-plus-square',
        'priority' =>'6',
        'pages' => [

            //2 уровень процесс математика
            [
                'title' => 'Математика',
                'priority' =>'0',
                'pages' => [

                    //3 уровень процесс математика
                        (new Page(\App\Models\ProcessMath::class))
                            ->setTitle('Процесс')
                            ->setIcon('far fa-dot-circle nav-icon')
                            ->setPriority(0),
                        [
                            'title' => 'Список наборов',
                            'icon' => 'far fa-dot-circle nav-icon',
                            'priority' =>'1',
                            'url' => 'admin/setoftask/math'
                        ]
                ]
            ],

            //2 уровень процесс физика
            [
                'title' => 'Физика',
                'priority' => '1',
                'pages' => [

                    //3 уровень процесс физика
                    (new Page(ProcessPhysics::class))
                        ->setTitle('Процесс')
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setPriority(0),
                    [
                        'title' => 'Список наборов',
                        'icon' => 'far fa-dot-circle nav-icon',
                        'priority' =>'1',
                        'url' => 'admin/setoftask/physics'
                    ]
                ]
            ],
            //2 уровень экзамены
            [
                'title' => 'Пробный экзамен',
                'priority' =>'2',
                'pages' => [
                    (new Page(Exam::class))
                        ->setTitle('Экзамены')
                        ->setPriority(0)
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(ExamSubject::class))
                        ->setTitle('Предметы')
                        ->setPriority(1)
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(ExamAnswer::class))
                        ->setTitle('Ответы')
                        ->setPriority(2)
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\ExamResult::class))
                        ->setTitle('Результаты')
                        ->setPriority(3)
                        ->setIcon('far fa-dot-circle nav-icon')
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                ]
            ]
        ]
    ],
    [
        'id' => 'users',
        'title' => 'Permissions',
        'icon' => 'fa fa-group',
        'priority' =>'7',
        'pages' => [
            (new Page(\App\User::class))
                ->setPriority(0)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin() ?? '';}),
            (new Page(\App\Role::class))
                ->setPriority(1)
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(Contact::class))
                ->setTitle('Контакты')
                ->setIcon('far fa-dot-circle nav-icon')
                ->setPriority(2)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(UserTransaction::class))
                ->setTitle('Транзакции')
                ->setIcon('far fa-dot-circle nav-icon')
                ->setPriority(3)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            [
                'title' => 'Рассылка писем',
                'icon' => 'far fa-dot-circle nav-icon',
                'priority' =>'3',
                'url' => 'admin/mail'
            ]
        ]
    ]
];
