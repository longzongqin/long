<?php

namespace App\Providers;

use App\Http\Model\Category;
use Illuminate\Support\ServiceProvider;

class CheckServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        view()->composer('common.app', function ($view) {
//            $menu = Category::getCategory();
//            $view->with('menu',$menu);
//        });
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
