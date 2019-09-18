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
        \App\Models\ArtifactType::class => 'App\Http\Sections\ArtifactsType',
        \App\Models\Artifact::class => 'App\Http\Sections\Artifacts',
        \App\Models\CategoryPhysics::class => 'App\Http\Sections\CategoriesPhysics',
        \App\Models\CategoryMath::class => 'App\Http\Sections\CategoriesMaths',
        \App\Models\ClassPerson::class => 'App\Http\Sections\ClassPersons',
        \App\Models\Contact::class => 'App\Http\Sections\Contacts',
        \App\Models\Exam::class => 'App\Http\Sections\Exams',
        \App\Models\ExamAnswer::class => 'App\Http\Sections\ExamAnswers',
        \App\Models\ExamResult::class => 'App\Http\Sections\ExamResults',
        \App\Models\ExamSubject::class => 'App\Http\Sections\ExamSubjects',
        \App\Models\Feature::class => 'App\Http\Sections\Features',
        \App\Models\GameDuel::class => 'App\Http\Sections\GameDuels',
        \App\Models\GradePhysics::class => 'App\Http\Sections\GradePhysics',
        \App\Models\GradeMath::class => 'App\Http\Sections\GradeMaths',
        \App\Models\ImageOfCharacter::class => 'App\Http\Sections\ImageOfCharacters',
        \App\Models\Menu::class => 'App\Http\Sections\Menus',
        \App\Models\Message::class => 'App\Http\Sections\Messages',
        \App\Models\Mission::class => 'App\Http\Sections\Missions',
        \App\Models\Newsletter::class => 'App\Http\Sections\Newsletters',
        \App\Models\Page::class => 'App\Http\Sections\Pages',
        \App\Models\Post::class => 'App\Http\Sections\Posts',
        \App\Models\ProcessPhysics::class => 'App\Http\Sections\ProcessesPhysics',
        \App\Models\ProcessMath::class => 'App\Http\Sections\ProcessesMaths',
        \App\Models\Progress::class => 'App\Http\Sections\Progresses',
        \App\Models\Rarity::class => 'App\Http\Sections\Rarities',
        \App\Models\SetOfTaskPhysics::class => 'App\Http\Sections\SetOfTaskPhysics',
        \App\Models\SetOfTaskMath::class => 'App\Http\Sections\SetOfTaskMaths',
        \App\Models\SetOfTaskType::class => 'App\Http\Sections\SetOfTaskTypes',
        \App\Models\Slot::class => 'App\Http\Sections\Slots',
        \App\Models\Stage::class => 'App\Http\Sections\Stages',
        \App\Models\SectionsPhysics::class => 'App\Http\Sections\SectionsPhysics',
        \App\Models\SectionsMath::class => 'App\Http\Sections\SectionsMaths',
        \App\Models\Tag::class => 'App\Http\Sections\Tags',
        \App\Models\TaskPhysics::class => 'App\Http\Sections\TaskPhysics',
        \App\Models\TaskMath::class => 'App\Http\Sections\TaskMaths',
        \App\Models\TrophyType::class => 'App\Http\Sections\TrophyTypes',
        \App\Models\Trophy::class => 'App\Http\Sections\Trophies',
        \App\Models\UserArtifact::class => 'App\Http\Sections\UserArtifacts',
        \App\Models\UserBody::class => 'App\Http\Sections\UserBodies',
        \App\Models\UserClass::class => 'App\Http\Sections\UserClasses',
        \App\Models\UserMission::class => 'App\Http\Sections\UserMissions',
        \App\Models\UserNewsletter::class => 'App\Http\Sections\UserNewsletter',
        \App\Models\UserProgress::class => 'App\Http\Sections\UserProgresses',
        \App\Models\UserTrophy::class => 'App\Http\Sections\UserTrophies',
        \App\Models\UserProperty::class => 'App\Http\Sections\UserProperties',
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
