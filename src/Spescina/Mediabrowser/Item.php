<?php namespace Spescina\Mediabrowser;

use Illuminate\Support\Facades\Config;
use Spescina\Mediabrowser\Facades\MediaBrowser;

class Item {

        /**
         * Public path of the resource
         * 
         * @var string
         */
        public $path;

        /**
         * Resource name
         * 
         * @var string
         */
        public $name;

        /**
         * Resource extension
         * 
         * @var string
         */
        public $extension;

        /**
         * Folder flag. True if the resource is a folder
         * 
         * @var bool 
         */
        public $folder;

        /**
         * Back flag. True if the resource is the back link
         *
         * @var bool
         */
        public $back;

        /**
         * Icon url
         *
         * @var string
         */
        public $icon;

        /**
         * Setup of the resource
         * 
         * @param string $fullPath
         * @param bool $folder
         */
        public function __construct($fullPath, $folder = false, $back = false)
        {
                $this->path = $this->extractPublicPath($fullPath);

                $this->name = $back ? '..' : $this->extractName($fullPath);

                $this->extension = MediaBrowser::extension($fullPath);

                $this->folder = $folder;

                $this->back = $back;

                $this->thumb = $this->thumbUrl();
        }

        /**
         * Return only the file|folder name
         * 
         * @param string $path
         * @return string
         */
        private function extractName($path)
        {
                $segments = explode('/', $path);

                return array_pop($segments);
        }

        /**
         * Remove the server private path from the full path of the resource
         * 
         * @param string $path
         * @return string
         */
        private function extractPublicPath($path)
        {
                $config = MediaBrowser::config();

                $rootPath = public_path($config['basepath']);

                $rootNode = self::pathToArray($rootPath);

                $pathNode = self::pathToArray($path);

                $diff = array_diff($pathNode, $rootNode);

                $relativePath = array($config['basepath']);

                $final = array_merge($relativePath, $diff);

                return implode('/', $final);
        }

        /**
         * Return the link to the resource icon
         *
         * @return string
         */
        private function thumb()
        {
                $preview = array('png', 'jpg', 'gif', 'bmp');

                $publicBaseUrl = 'packages/spescina/mediabrowser/src/img/icons/';

                if ($this->folder)
                {
                        if ($this->back)
                        {
                                $icon = 'back';
                        }
                        else
                        {
                                $icon = 'folder';
                        }

                        $url = $publicBaseUrl . $icon . '.png';
                }
                else
                {
                        if (in_array($this->extension, $preview))
                        {
                                $url = $this->path;
                        }
                        else
                        {
                                $url = $publicBaseUrl . $this->extension . '.png';
                        }
                }

                return $url;
        }
        
        /**
         * Return the item url
         * 
         * @param int $width
         * @param int $height
         * @return string
         */
        public function thumbUrl($width = null, $height = null)
        {
                $resourceUrl = $this->thumb();
                
                $url = ($this->config('imgproxy')) ? $this->imgproxyResizerUrl($resourceUrl, $width, $height) : $resourceUrl;
                
                return asset($url);
        }
        
        /**
         * Return the prefixed url including the resizing prefix of the imgproxy package
         * 
         * @param string $resourceUrl
         * @param int $width
         * @param int $height
         * @return string
         */
        private function imgproxyResizerUrl($resourceUrl, $width, $height)
        {
                $width = is_null($width) ? $this->config('thumbs.width') : $width;
                
                $height = is_null($height) ? $this->config('thumbs.height') : $height;
                
                $resizePrefix = "packages/spescina/imgproxy/$width/$height/2/70/";
                
                return $resizePrefix . $resourceUrl;
        }

        /**
         * Convert the path in array splitted by the forward slash separator
         * 
         * @param string $path
         * @return array
         */
        static function pathToArray($path)
        {
                return explode('/', $path);
        }
        
        /**
         * Get a config value from the config object
         * 
         * @param string $key
         * @return string
         */
        private function config($key)
        {
                return Config::get('mediabrowser::mediabrowser.' . $key);
        }

}
