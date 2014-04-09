<?php namespace Psimone\Mediabrowser\Classes;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Psimone\Mediabrowser\Classes\Item;

class Medialibrary {

        private $items = array();
        private $config;
        private $field;
        private $path;

        const ALL_TYPE = 'all';
        const AUDIO_TYPE = 'audio';
        const DOC_TYPE = 'doc';
        const IMAGE_TYPE = 'image';
        const VIDEO_TYPE = 'video';

        public function __construct()
        {
                $this->config = Config::get('mediabrowser::medialibrary');
        }

        /**
         * Return objects in the given path
         * 
         * @param string $path
         * @param string $field
         * @return boolean
         */
        public function browsePath($path, $field)
        {
                $realPath = public_path($path);

                if (!$this->validatePath($realPath))
                {
                        return false;
                }

                $this->path = $path;

                $folders = self::getFolders($realPath);

                $this->parseFolders($folders);

                $files = self::getFiles($realPath);

                $this->parseFiles($files, $field);
        }

        /**
         * Return folders in path
         *
         * @param string $path
         * @return mixed
         */
        private static function getFolders($path)
        {
                return File::directories($path);
        }

        /**
         * Return files in path
         *
         * @param string $path
         * @return mixed
         */
        private static function getFiles($path)
        {
                return File::files($path);
        }

        /**
         * Checl if the given path passes the filesystem validation
         *
         * @param string $path
         * @return boolean
         */
        private function validatePath($path)
        {
                if (!File::exists($path))
                {
                        return false;
                }

                if (!File::isDirectory($path))
                {
                        return false;
                }

                return true;
        }

        /**
         * Return the local config var in json notation
         * embeddable as a javascript config object
         *
         * @return json
         */
        public function configToJSON()
        {
                return json_encode($this->config());
        }

        /**
         * Set the config array of the component in the local var
         * 
         * @return array
         */
        public function config()
        {
                return $this->config;
        }

        /**
         * Add folders to the local item list
         * 
         * @param array $items
         */
        private function parseFolders($items)
        {
                foreach ($items as $item)
                {
                        $this->items[] = new Item($item, true);
                }
        }

        /**
         * Add files to the local item list
         * 
         * @param array $items
         * @param string $field
         */
        private function parseFiles($items, $field)
        {
                foreach ($items as $item)
                {
                        $extension = self::extension($item);

                        if ($this->allowed($extension, $field))
                        {
                                $this->items[] = new Item($item);
                        }
                }
        }

        /**
         * Return the local item list
         * 
         * @return array
         */
        public function getItems()
        {
                $items = array();

                if (!$this->isRoot())
                {
                        $items[] = new Item($this->parentFolder(), true, true);
                }

                $final = array_merge($items, $this->items);

                return $final;
        }

        /**
         * Return the type of the resource
         * 
         * @param string $path
         */
        static function extension($path)
        {
                return File::extension($path);
        }

        /**
         * Check if the resource is allowed
         * 
         * @param string $extension
         * @param string $field
         * @return bool
         */
        private function allowed($extension, $field)
        {
                if (in_array($extension, $this->allowedExtensions($field)))
                {
                        return true;
                }

                return false;
        }

        /**
         * Check if the given path is the library root
         *
         * @return bool
         */
        private function isRoot()
        {
                if ($this->path === $this->config['basepath'])
                {
                        return true;
                }

                return false;
        }

        /**
         * Return the parent folder
         *
         * @return string
         */
        private function parentFolder()
        {
                if ($this->isRoot())
                {
                        return $this->config['basepath'];
                }

                $segments = $this->pathToArray($this->path);

                array_pop($segments);

                return $this->arrayToPath($segments);
        }

        /**
         * Convert given path in an array of segments
         *
         * @param string path
         * @returns array
         */
        private function pathToArray($path)
        {
                return explode('/', $path);
        }

        /**
         * Convert given array of segments in a path
         *
         * @param array segments
         * @returns string
         */
        private function arrayToPath($segments)
        {
                return implode('/', $segments);
        }

        /**
         * Return the localized requested string
         *
         * @param string $section
         * @return string
         */
        public function localize($section)
        {
                return Lang::get('mediabrowser::medialibrary.' . $section);
        }

        /**
         * Create a folder at the given path
         * 
         * @param string $path
         * @param string $folder
         * @return boolean
         */
        public function folderCreate($path, $folder)
        {
                $realPath = public_path($path . '/' . $folder);

                File::makeDirectory($realPath);

                return true;
        }

        /**
         * Delete the folder with the given path
         * 
         * @param string $folder
         * @return boolean
         */
        public function folderDelete($folder)
        {
                $realPath = public_path($folder);

                if (!File::isDirectory($realPath))
                {
                        return false;
                }

                File::deleteDirectory($realPath);

                return true;
        }

        /**
         * Delete the file with the given path
         * 
         * @param string $file
         * @return boolean
         */
        public function fileDelete($file)
        {
                $realPath = public_path($file);

                if (!File::isFile($realPath))
                {
                        return false;
                }

                File::delete($realPath);

                return true;
        }

        /**
         * Return allowed file extensions configured for the current field
         * 
         * @param string $field
         * @return array
         */
        public function allowedExtensions($field)
        {
                $fields = Session::get('formFields');

                $medialibraryType = $fields[$field]['allowed'];

                if ($medialibraryType === self::ALL_TYPE)
                {

                        $extensions = array();

                        foreach ($this->config['types'] as $ext)
                        {
                                $extensions = array_merge($extensions, $ext);
                        }

                        return $extensions;
                }

                return $this->config['types'][$medialibraryType];
        }

        /**
         * Return the json formatted allowed file extensions
         * 
         * @param string $field
         * @return string
         */
        public function jsonAllowedExtensions($field)
        {
                return json_encode($this->allowedExtensions($field));
        }

}
