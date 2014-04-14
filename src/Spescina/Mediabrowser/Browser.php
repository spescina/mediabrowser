<?php namespace Spescina\Mediabrowser;

use Illuminate\Support\Facades\Session;
use Spescina\Mediabrowser\Facades\Filesystem;
use Spescina\Mediabrowser\Item;
use Spescina\PkgSupport\PackageInterface;
use Spescina\PkgSupport\ServiceInterface;

class Browser implements PackageInterface {

        use \Spescina\PkgSupport\PkgTrait;

        private $items = array();
        private $path;

        const TYPE_ALL = 'all';
        const TYPE_AUDIO = 'audio';
        const TYPE_DOC = 'doc';
        const TYPE_IMAGE = 'image';
        const TYPE_VIDEO = 'video';

        public function __construct(ServiceInterface $config, ServiceInterface $lang)
        {
                $this->config = $config;
                $this->lang = $lang;
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

                if (!Filesystem::validatePath($realPath))
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
                return json_encode($this->conf());
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
                if ($this->path === $this->conf('basepath'))
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
                        return $this->conf('basepath');
                }

                $segments = Filesystem::pathToArray($this->path);

                array_pop($segments);

                return Filesystem::arrayToPath($segments);
        }

        /**
         * Return allowed file extensions configured for the current field
         * 
         * @param string $field
         * @return array
         * @throws \Exception
         */
        public function allowedExtensions($field)
        {
                $mediabrowserType = $this->getType($field);

                if ($mediabrowserType === self::TYPE_ALL)
                {
                        return $this->getAllAllowedExtensions();
                }
                
                $types = $this->conf("types");
                
                if ( ! isset($types[$mediabrowserType])) {
                        throw new \Exception;
                }
                
                return $types[$mediabrowserType];
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
        
        /**
         * Return the type of the instantiated mediabrowser
         * 
         * @param type $field
         * @return type
         * @throws \Exception
         */
        private function getType($field)
        {
                $fields = Session::get('formFields');

                if ( ! isset($fields[$field]['allowed'])) {
                        throw new \Exception;
                }
                
                return $fields[$field]['allowed'];
        }
        
        /**
         * Return all allowed defined extensions
         * 
         * @return array
         */
        private function getAllAllowedExtensions()
        {
                $extensions = array();

                foreach ($this->conf('types') as $ext)
                {
                        $extensions = array_merge($extensions, $ext);
                }
                
                return $extensions;
        }

}
