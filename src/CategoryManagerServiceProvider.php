<?php

namespace Devdojo\CategoryManager;

use Illuminate\Support\ServiceProvider;

class CategoryManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__. '/routes.php';
        $this->publishes([
            __DIR__.'category/public' => public_path('/'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->make('Devdojo\CategoryManager\Controllers\TaxonomyController');
        $this->app->make('Devdojo\CategoryManager\Models\Taxonomy');
        $this->loadViewsFrom(__DIR__.'/views', 'CategoryManager');
    }
}
