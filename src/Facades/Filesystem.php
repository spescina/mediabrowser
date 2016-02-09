<?php namespace Spescina\Mediabrowser\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method arrayToPath
 * @method pathToArray
 * @method extension
 * @method extractName
 * @method fileDelete
 * @method folderCreate
 * @method folderDelete
 * @method getFiles
 * @method getFolders
 * @method getPath
 * @method validatePath
 */
class Filesystem extends Facade {

        /**
         * Get the registered name of the component.
         *
         * @return string
         */
        protected static function getFacadeAccessor()
        {
                return 'mediabrowser.filesystem';
        }

}
