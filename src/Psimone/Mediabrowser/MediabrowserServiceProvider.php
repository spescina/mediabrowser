<?php namespace Psimone\Mediabrowser;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Psimone\Mediabrowser\Classes\Medialibrary;

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
                $this->package('psimone/mediabrowser');

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
                    'mediabrowser.medialibrary',
                );
        }

        private function registerAlias()
        {
                AliasLoader::getInstance()->alias('MediaLibrary', 'Psimone\Mediabrowser\Facades\MediaLibrary');
        }

        private function registerServices()
        {
                $this->app['mediabrowser.medialibrary'] = $this->app->share(function($app) {
                        return new Medialibrary();
                });
        }
}
