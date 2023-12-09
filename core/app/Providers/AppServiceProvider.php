<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return realpath(base_path().'/..');
          });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer('*', function ($view) 
        {
            if(\Auth::check()){
                $access = \App\Modules\User\Models\RolePermission::where("id",\Auth::guard("web")->user()->role_id)->first();
                $access ? config(['global.access' => json_decode($access->permission)]) : "";
            }
        });  
        
    }
}
