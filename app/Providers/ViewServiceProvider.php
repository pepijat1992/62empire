<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\User;
use App\Agent;
use App\Admin;
use App\Models\Setting;

use Auth;

class ViewServiceProvider extends ServiceProvider
{
    
    protected $user, $admin, $agent, $setting;

    public function __construct(){
        $this->auth_user = [

        ];

        $this->admin = [
            'admin.*'
        ];

        $this->agent = [
            'agent.*'
        ];

        $this->user = [
            'wap.*',
            'web.*'
        ];

        $this->setting = [
            '*',
        ];
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer($this->admin, function ($view) {
            $_admin = Auth::guard('admin')->user();
            $view->with(compact('_admin'));
        });

        view()->composer($this->agent, function ($view) {
            $_agent = Auth::guard('agent')->user();
            $view->with(compact('_agent'));
        });

        view()->composer($this->user, function ($view) {
            $_user = Auth::user();
            $view->with(compact('_user'));
        });

        view()->composer($this->setting, function ($view) {
            $_setting = Setting::find(1);
            $view->with(compact('_setting'));
        });
    }
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
