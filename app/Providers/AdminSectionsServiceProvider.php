<?php

namespace App\Providers;

use App\Models\Action;
use App\Models\ActionType;
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
use App\Models\ExamResult;
use App\Models\ExamSubject;
use App\Models\Feature;
use App\Models\GameDuel;
use App\Models\GradeMath;
use App\Models\GradePhysics;
use App\Models\ImageOfCharacter;
use App\Models\Menu;
use App\Models\Message;
use App\Models\Mission;
use App\Models\Monster;
use App\Models\MonsterType;
use App\Models\Newsletter;
use App\Models\Page;
use App\Models\Post;
use App\Models\ProcessMath;
use App\Models\ProcessPhysics;
use App\Models\Progress;
use App\Models\Rarity;
use App\Models\School;
use App\Models\SectionsMath;
use App\Models\SectionsPhysics;
use App\Models\SetOfTaskMath;
use App\Models\SetOfTaskPhysics;
use App\Models\SetOfTaskType;
use App\Models\ShopItem;
use App\Models\Skill;
use App\Models\SkillType;
use App\Models\Slot;
use App\Models\Stage;
use App\Models\Tag;
use App\Models\TaskMath;
use App\Models\TaskPhysics;
use App\Models\Trophy;
use App\Models\TrophyType;
use App\Models\UserAction;
use App\Models\UserArtifact;
use App\Models\UserBody;
use App\Models\UserClass;
use App\Models\UserMission;
use App\Models\UserNewsletter;
use App\Models\UserProgress;
use App\Models\UserProperty;
use App\Models\UserTransaction;
use App\Models\UserTrophy;
use App\Role;
use App\User;
use App\Widgets\NavigationNotifications;
use App\Widgets\NavigationUserBlock;
use SleepingOwl\Admin\Admin;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;
use SleepingOwl\Admin\Contracts\Navigation\NavigationInterface;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected array $widgets = [
       // \App\Widgets\DashboardMap::class,
        NavigationNotifications::class,
        NavigationUserBlock::class
    ];
    protected $sections = [
        User::class => 'App\Http\Sections\Users',
        Role::class => 'App\Http\Sections\Roles',
        Action::class => 'App\Http\Sections\Actions',
        ActionType::class => 'App\Http\Sections\ActionsType',
        Monster::class => 'App\Http\Sections\Monsters',
        MonsterType::class => 'App\Http\Sections\MonstersType',
        Skill::class => 'App\Http\Sections\Skills',
        SkillType::class => 'App\Http\Sections\SkillsType',
        Battle::class => 'App\Http\Sections\Battles',
        ArtifactType::class => 'App\Http\Sections\ArtifactsType',
        Artifact::class => 'App\Http\Sections\Artifacts',
        ArtifactTrade::class => 'App\Http\Sections\ArtifactsTrade',
        CategoryPhysics::class => 'App\Http\Sections\CategoriesPhysics',
        CategoryMath::class => 'App\Http\Sections\CategoriesMaths',
        ClassPerson::class => 'App\Http\Sections\ClassPersons',
        Contact::class => 'App\Http\Sections\Contacts',
        Exam::class => 'App\Http\Sections\Exams',
        ExamAnswer::class => 'App\Http\Sections\ExamAnswers',
        ExamResult::class => 'App\Http\Sections\ExamResults',
        ExamSubject::class => 'App\Http\Sections\ExamSubjects',
        Feature::class => 'App\Http\Sections\Features',
        GameDuel::class => 'App\Http\Sections\GameDuels',
        GradePhysics::class => 'App\Http\Sections\GradePhysics',
        GradeMath::class => 'App\Http\Sections\GradeMaths',
        ImageOfCharacter::class => 'App\Http\Sections\ImageOfCharacters',
        Menu::class => 'App\Http\Sections\Menus',
        Message::class => 'App\Http\Sections\Messages',
        Mission::class => 'App\Http\Sections\Missions',
        Newsletter::class => 'App\Http\Sections\Newsletters',
        Page::class => 'App\Http\Sections\Pages',
        Post::class => 'App\Http\Sections\Posts',
        ProcessPhysics::class => 'App\Http\Sections\ProcessesPhysics',
        ProcessMath::class => 'App\Http\Sections\ProcessesMaths',
        Progress::class => 'App\Http\Sections\Progresses',
        Rarity::class => 'App\Http\Sections\Rarities',
        School::class => 'App\Http\Sections\Schools',
        SetOfTaskPhysics::class => 'App\Http\Sections\SetOfTaskPhysics',
        SetOfTaskMath::class => 'App\Http\Sections\SetOfTaskMaths',
        SetOfTaskType::class => 'App\Http\Sections\SetOfTaskTypes',
        ShopItem::class => 'App\Http\Sections\ShopItems',
        Slot::class => 'App\Http\Sections\Slots',
        Stage::class => 'App\Http\Sections\Stages',
        SectionsPhysics::class => 'App\Http\Sections\SectionsPhysics',
        SectionsMath::class => 'App\Http\Sections\SectionsMaths',
        Tag::class => 'App\Http\Sections\Tags',
        TaskPhysics::class => 'App\Http\Sections\TaskPhysics',
        TaskMath::class => 'App\Http\Sections\TaskMaths',
        TrophyType::class => 'App\Http\Sections\TrophyTypes',
        Trophy::class => 'App\Http\Sections\Trophies',
        UserAction::class => 'App\Http\Sections\UserActions',
        UserArtifact::class => 'App\Http\Sections\UserArtifacts',
        UserBody::class => 'App\Http\Sections\UserBodies',
        UserClass::class => 'App\Http\Sections\UserClasses',
        UserMission::class => 'App\Http\Sections\UserMissions',
        UserNewsletter::class => 'App\Http\Sections\UserNewsletters',
        UserProgress::class => 'App\Http\Sections\UserProgresses',
        UserTransaction::class => 'App\Http\Sections\UserTransactions',
        UserTrophy::class => 'App\Http\Sections\UserTrophies',
        UserProperty::class => 'App\Http\Sections\UserProperties',
    ];

    /**
     * Register sections.
     *
     * @param Admin $admin
     * @return void
     */
    public function boot(Admin $admin): void
    {
        parent::boot($admin);
        $this->app->call([$this, 'registerViews']);

    }

    /**
     * @param WidgetsRegistryInterface $widgetsRegistry
     */
    public function registerViews(WidgetsRegistryInterface $widgetsRegistry): void
    {
        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }
}
