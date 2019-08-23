<?php

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
            (new Page(\App\Models\Mission::class))
                ->setTitle('Создать задания')
                ->setPriority(1)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\UserMission::class))
                ->setTitle('Задания учеников')
                ->setPriority(2)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\ImageOfCharacter::class))
                ->setTitle('Создать образ')
                ->setPriority(3)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\UserBody::class))
                ->setTitle('Образы учеников')
                ->setPriority(4)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),

            //3 уровень - Артифакты
            [
                'title' => 'Артифакты',
                'priority' =>'5',
                'pages' => [
                    (new Page(\App\Models\Artifact::class))
                        ->setTitle('Создать артифакт')
                        ->setPriority(1),
                    (new Page(\App\Models\ArtifactType::class))
                        ->setTitle('Тип артифакта')
                        ->setPriority(2)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\UserArtifact::class))
                        ->setTitle('Артифакты учеников')
                        ->setPriority(3)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\Rarity::class))
                        ->setTitle('Редкость')
                        ->setPriority(4)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                ],
            ],
            (new Page(\App\Models\ClassPerson::class))
                ->setTitle('Создать классы')
                ->setPriority(5),
            (new Page(\App\Models\UserClass::class))
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

                    (new Page(\App\Models\CategoryMath::class))
                        ->setTitle('Разделы')
                        ->setPriority(1),
                    (new Page(\App\Models\SectionsMath::class))
                        ->setTitle('Темы')
                        ->setPriority(2),
                    (new Page(\App\Models\TaskMath::class))
                        ->setTitle('Задачи')
                        ->setPriority(3),
                    (new Page(\App\Models\SetOfTaskMath::class))
                        ->setTitle('Набор задач')
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

                    (new Page(\App\Models\CategoryPhysics::class))
                        ->setTitle('Разделы')
                        ->setPriority(1)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\SectionsPhysics::class))
                        ->setTitle('Темы')
                        ->setPriority(2)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\TaskPhysics::class))
                        ->setTitle('Задачи')
                        ->setPriority(3)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\SetOfTaskPhysics::class))
                        ->setTitle('Набор задач')
                        ->setPriority(4)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                ]
            ],
            (new Page(\App\Models\Stage::class))
                ->setTitle('Этапы')
                ->setPriority(3)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\Progress::class))
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
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\Menu::class))
                ->setTitle('Меню')
                ->setPriority(1)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\Post::class))
                ->setTitle('Посты')
                ->setPriority(2)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\Tag::class))
                ->setTitle('Теги')
                ->setPriority(3)
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
                            ->setPriority(0),
                        [
                            'title' => 'Список наборов',
                            'icon' => '',
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
                    (new Page(\App\Models\ProcessPhysics::class))
                        ->setTitle('Процесс')
                        ->setPriority(0),
                    [
                        'title' => 'Список наборов',
                        'icon' => '',
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
                    (new Page(\App\Models\Exam::class))
                        ->setTitle('Экзамены')
                        ->setPriority(0)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\ExamSubject::class))
                        ->setTitle('Предметы')
                        ->setPriority(1)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\ExamAnswer::class))
                        ->setTitle('Ответы')
                        ->setPriority(2)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                    (new Page(\App\Models\ExamResult::class))
                        ->setTitle('Результаты')
                        ->setPriority(3)
                        ->setAccessLogic(function() {
                            return auth()->user()->isSuperAdmin();}),
                ]
            ]
        ]
    ],
    [
        'title' => 'Permissions',
        'icon' => 'fa fa-group',
        'priority' =>'7',
        'pages' => [
            (new Page(\App\User::class))
                ->setPriority(0)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Role::class))
                ->setPriority(1)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            (new Page(\App\Models\Contact::class))
                ->setTitle('Контакты')
                ->setPriority(2)
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}),
            [
                'title' => 'Рассылка писем',
                'icon' => '',
                'priority' =>'3',
                'url' => 'admin/mail'
            ]
        ]
    ]
];