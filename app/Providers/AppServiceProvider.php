<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Regulatory\Accreditation;
use App\Regulatory\HCO;
use App\Regulatory\Building;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $system_admin_accreditations = Accreditation::get();
        view()->share('system_admin_accreditations', $system_admin_accreditations);

        view()->composer('*', function($view) {
            if (Auth::check()) {
                $modal_hcos = HCO::where('healthsystem_id',Auth::guard('system_user')->user()->healthSystem->id)->pluck('facility_name','id')->prepend('Please select a hco', '0');
                $view->with('modal_hcos', $modal_hcos);
            }

            if(session()->has('building_id'))
            {
                $sidebar_building = Building::find(session('building_id'));
                $view->with('sidebar_building', $sidebar_building);
            }
        });
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
