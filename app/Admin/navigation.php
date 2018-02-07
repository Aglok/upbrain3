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
            ],
        ]
    ],
    [
        'title' => 'Интерфейс',
        'icon' => 'fa fa-id-card',
        'priority' =>'3',
        'pages' => [
            
            //2 уровень Создать задания
            [
                'title' => 'Создать задания',
                'url'   => route('list_missions'),
                'priority' =>'1'
            ],
            (new Page(\App\Models\User_Mission::class))
                ->setTitle('Задания учеников')
                ->setPriority(2),
            (new Page(\App\Models\Image_Of_Character::class))
                ->setTitle('Создать образ')
                ->setPriority(3),
            (new Page(\App\Models\User_Body::class))
                ->setTitle('Образы учеников')
                ->setPriority(4),

            //3 уровень - Артифакты
            [
                'title' => 'Артифакты',
                'priority' =>'5',
                'pages' => [
                    (new Page(\App\Models\Artifact::class))
                        ->setTitle('Создать артифакт')
                        ->setPriority(1),
                    (new Page(\App\Models\Artifact_Type::class))
                        ->setTitle('Тип артифакта')
                        ->setPriority(2),
                    (new Page(\App\Models\User_Artifact::class))
                        ->setTitle('Артифакты учеников')
                        ->setPriority(3),
                    (new Page(\App\Models\Rarity::class))
                        ->setTitle('Редкость')
                        ->setPriority(4),
                ],
            ],
            (new Page(\App\Models\Class_Person::class))
                ->setTitle('Создать классы')
                ->setPriority(5),
            (new Page(\App\Models\User_Class::class))
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

                    (new Page(\App\Models\Category_Subject::class))
                        ->setTitle('Разделы')
                        ->setPriority(1),
                    (new Page(\App\Models\Subject::class))
                        ->setTitle('Темы')
                        ->setPriority(2),
                    (new Page(\App\Models\Task::class))
                        ->setTitle('Задачи')
                        ->setPriority(3),
                    (new Page(\App\Models\Set_Of_Task::class))
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

                    (new Page(\App\Models\Category_Subject_Physics::class))
                        ->setTitle('Разделы')
                        ->setPriority(1),
                    (new Page(\App\Models\Subject_Physics::class))
                        ->setTitle('Темы')
                        ->setPriority(2),
                    (new Page(\App\Models\Task_Physics::class))
                        ->setTitle('Задачи')
                        ->setPriority(3),
                    (new Page(\App\Models\Set_Of_Task_Physics::class))
                        ->setTitle('Набор задач')
                        ->setPriority(4),
                ]
            ],
            (new Page(\App\Models\Stage::class))
                ->setTitle('Этапы')
                ->setPriority(3),
            (new Page(\App\Models\Progress::class))
                ->setTitle('Достижения')
                ->setPriority(4),
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
                ->setPriority(0),
            (new Page(\App\Models\Menu::class))
                ->setTitle('Меню')
                ->setPriority(1),
            (new Page(\App\Models\Post::class))
                ->setTitle('Посты')
                ->setPriority(2),
            (new Page(\App\Models\Tag::class))
                ->setTitle('Теги')
                ->setPriority(3)
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
                        (new Page(\App\Models\Process::class))
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
                    (new Page(\App\Models\Process_Physics::class))
                        ->setTitle('Процесс')
                        ->setPriority(0),
                    [
                        'title' => 'Список наборов',
                        'icon' => '',
                        'priority' =>'1',
                        'url' => 'admin/setoftask/physics'
                    ]
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
                ->setIcon('fa fa-user')
                ->setPriority(0),
            (new Page(\App\Role::class))
                ->setIcon('fa fa-group')
                ->setPriority(1)
        ]
    ]
];