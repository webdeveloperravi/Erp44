<?php

namespace App\Providers;

use App\Model\Admin\Setting\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Model\Store\StoreUserRoleModule;
use App\Model\Admin\Setting\WarehouseRole;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('mg', ' mg');
        view()->share('storeUserTypesAll', ['user', 'bank', 'others', 'customer']);
        view()->share('storeTypesAll', ['org', 'lab']);
        Blade::component('demo', \App\View\Components\front\Sidebar::class);
        // view()->share('users', \App\Model\Guard\UserStore::first());
        // Schema::defaultStruingLength(191);
    }
}
