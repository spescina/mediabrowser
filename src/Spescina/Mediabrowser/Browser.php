<?php namespace Spescina\Mediabrowser;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Spescina\Mediabrowser\Facades\Filesystem;
use Spescina\Mediabrowser\Item;

class Browser {

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
                $this->config = Config::get('mediabrowser::mediabrowser');
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

                if ( ! Filesystem::validatePath($realPath))
                {
                        return false;
                }

                $this->path = $path;

                $folders = Filesystem::getFolders($realPath);

                $this->parseFolders($folders);

                $files = Filesystem::getFiles($realPath);

                $this->parseFiles($files, $field);
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
                        $extension = Filesystem::extension($item);

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

                $segments = Filesystem::pathToArray($this->path);

                array_pop($segments);

                return Filesystem::arrayToPath($segments);
        }

        /**
         * Return the localized requested string
         *
         * @param string $section
         * @return string
         */
        public function localize($section)
        {
                return Lang::get('mediabrowser::mediabrowser.' . $section);
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

                $mediabrowserType = $fields[$field]['allowed'];

                if ($mediabrowserType === self::ALL_TYPE)
                {

                        $extensions = array();

                        foreach ($this->config['types'] as $ext)
                        {
                                $extensions = array_merge($extensions, $ext);
                        }

                        return $extensions;
                }

                return $this->config['types'][$mediabrowserType];
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
