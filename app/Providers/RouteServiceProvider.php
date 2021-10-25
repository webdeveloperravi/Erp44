<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

        protected $namespace = 'App\Http\Controllers';
        protected $admin_namespace = 'App\Http\Controllers\Admin';
        protected $setting_namespace = 'App\Http\Controllers\Admin\Setting';


        public const HOME = '/home';


        public function boot()
        {
                parent::boot();
        }


        public function map()
        {
                $this->mapApiRoutes();

                $this->mapWebRoutes();

                $this->mapAdminRoutes();

                $this->mapWareHouseRoutes();

                $this->mapStoreRoutes();
        }


        protected function mapWebRoutes()
        {
                Route::middleware('web')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/web.php'));
        }

        protected function mapAdminRoutes()
        {
                Route::middleware('web')->prefix('admin')->namespace($this->admin_namespace)
                        ->group(base_path('routes/admin.php'));
        }

        protected function mapWareHouseRoutes()
        {
                Route::middleware('web')->prefix('warehouse')->namespace($this->namespace)
                        ->group(base_path('routes/warehouse.php'));
        }

        protected function mapStoreRoutes()
        {
                Route::middleware('web')->prefix('store')->namespace($this->namespace)
                        ->group(base_path('routes/store.php'));
        }


        protected function mapApiRoutes()
        {
                Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group(base_path('routes/api.php'));
        }
}
