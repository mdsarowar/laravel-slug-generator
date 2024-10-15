<?php
namespace Sarowar\LaravelSlugGenerator;

use Illuminate\Support\ServiceProvider;

class LaravelSlugServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('laravel-slug-generator',function ($app){
            return new \Sarowar\LaravelSlugGenerator\LaravelSlug();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Publish the configuration file
        $this->publishes([
            __DIR__.'/config/slug-generator.php' => config_path('sarowar-slug-generator.php'),
        ]);

        // Load the configuration file
        $this->mergeConfigFrom(
            __DIR__.'/config/slug-generator.php', 'sarowar-slug-generator'
        );
    }
}
