<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Regulatory\Accreditation;

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
