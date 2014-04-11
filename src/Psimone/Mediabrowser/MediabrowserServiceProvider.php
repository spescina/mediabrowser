<?php namespace Spescina\Mediabrowser;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Spescina\Mediabrowser\Medialibrary;

class MediabrowserServiceProvider extends ServiceProvider {

	/**
         * Indicates if loading of the provider is deferred.
         *
         * @var bool
         */
        protected $defer = false;

        /**
         * Bootstrap the application events.
         *
         * @return void
         */
        public function boot()
        {
                $this->package('spescina/mediabrowser');

                include __DIR__ . '/../../routes.php';

                include __DIR__ . '/../../composers.php';
        }

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register()
        {
                $this->registerServices();

                $this->registerAlias();
        }

        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
        public function provides()
        {
                return array(
                    'mediabrowser',
                );
        }

        private function registerAlias()
        {
                AliasLoader::getInstance()->alias('MediaLibrary', 'Spescina\Mediabrowser\Facades\MediaLibrary');
        }

        private function registerServices()
        {
                $this->app['mediabrowser'] = $this->app->share(function($app) {
                        return new Medialibrary();
                });
        }
}
