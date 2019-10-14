<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Providers\RepositoryServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $repoServiceProvider = new RepositoryServiceProvider($this->app);
        $repoServiceProvider->register();
    }
}
