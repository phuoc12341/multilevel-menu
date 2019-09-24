<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected static $repositories = [
        'base' => [
            \App\Repo\BaseRepositoryInterface::class,
            \App\Repo\BaseRepository::class,
        ],
        'menu' => [
            \App\Repo\MenuRepositoryInterface::class,
            \App\Repo\MenuRepository::class,
        ],
        'post' => [
            \App\Repo\PostRepositoryInterface::class,
            \App\Repo\PostRepository::class,
        ],
        'page' => [
            \App\Repo\PageRepositoryInterface::class,
            \App\Repo\PageRepository::class,
        ],
    ];
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (static::$repositories as $repository) {
            $this->app->singleton(
                $repository[0],
                $repository[1]
            );
        }
    }
}
