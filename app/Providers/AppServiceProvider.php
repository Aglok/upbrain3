<?php

namespace App\Providers;

use App\Models\ClassPerson;
use App\Models\UserClass;
use App\Models\UserMission;
use App\Observers\ClassPersonObserver;
use App\Observers\UserClassObserver;
use App\Observers\UserMissionObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use App\User;
use App\Observers\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
//        if (file_exists($assetsFile = __DIR__ . '/../../resources/assets/admin/assets.php')) {
//            include $assetsFile;
//        }
        //Макрос для коллекции который прогоняет через созданный класс Present объект модели
        Collection::macro('present', function ($class) {
            return $this->map(function ($model) use ($class) {
                return new $class($model);
            });
        });

        //Создаём обсервер для прослушивания модели User
        User::observe(UserObserver::class);
        ClassPerson::observe(ClassPersonObserver::class);
        UserMission::observe(UserMissionObserver::class);
        UserClass::observe(UserClassObserver::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
