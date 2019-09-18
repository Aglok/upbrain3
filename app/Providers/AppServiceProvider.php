<?php

namespace App\Providers;

use App\Models\ClassPerson;
use App\Observers\ClassPersonObserver;
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
    public function boot()
    {
//        if (file_exists($assetsFile = __DIR__ . '/../../resources/assets/admin/assets.php')) {
//            include $assetsFile;
//        }
        //Макрос для коллеции который прогоняет через созданный класс Present объект модели
        Collection::macro('present', function ($class) {
            return $this->map(function ($model) use ($class) {
                return new $class($model);
            });
        });

        //Создаём обсервер для прослушивания модели User
        User::observe(UserObserver::class);
        ClassPerson::observe(ClassPersonObserver::class);

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
