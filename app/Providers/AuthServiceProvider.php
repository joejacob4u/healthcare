<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerFaciltyMaintenancePolicies();
    }

    //gates for facilty maintenance

    public function registerFaciltyMaintenancePolicies()
    {
        //a user has the permission to add or remove fm user
        Gate::define('manage.fm-user', function ($user) {
            return $user->role->hasPermission('manage.fm-user');
        });

        //a user has permission to view an equipment
        Gate::define('view.equipment', function ($user) {
            return $user->role->hasPermission('view.equipment');
        });
    }
}
