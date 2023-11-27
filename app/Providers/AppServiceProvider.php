<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $currentPage = request()->input('page', 1);
        $perPage = 15;
        $startIndex = ($currentPage - 1) * $perPage;

        view()->share([
            'startIndex'=> $startIndex
        ]);
    }
}
