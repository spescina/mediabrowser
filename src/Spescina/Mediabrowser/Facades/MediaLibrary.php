<?php namespace Spescina\Mediabrowser\Facades;

use Illuminate\Support\Facades\Facade;

class MediaLibrary extends Facade {

        /**
         * Get the registered name of the component.
         *
         * @return string
         */
        protected static function getFacadeAccessor()
        {
                return 'mediabrowser';
        }

}
