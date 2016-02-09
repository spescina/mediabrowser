<?php namespace Spescina\Mediabrowser\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Spescina\Mediabrowser\Browser;
use Spescina\Mediabrowser\Filesystem;

class MediabrowserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'mediabrowser');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'mediabrowser');

        $this->mergeConfigFrom(__DIR__ . '/../../config/mediabrowser.php', 'mediabrowser');

        $this->publishes([__DIR__ . '/../../resources/assets' => public_path('packages/spescina/mediabrowser')], 'assets');

        if (!$this->app->routesAreCached()) {
            include __DIR__ . '/../Http/routes.php';
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('mediabrowser.mediabrowser', function ($app) {
            return new Browser();
        });

        $this->app->singleton('mediabrowser.filesystem', function ($app) {
            return new Filesystem();
        });

        AliasLoader::getInstance()->alias('Mediabrowser', 'Spescina\Mediabrowser\Facades\Mediabrowser');
        AliasLoader::getInstance()->alias('Filesystem', 'Spescina\Mediabrowser\Facades\Filesystem');
    }

}
