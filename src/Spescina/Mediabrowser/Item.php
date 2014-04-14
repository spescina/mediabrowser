<?php namespace Spescina\Mediabrowser;

use Spescina\Mediabrowser\Facades\Filesystem;
use Spescina\Mediabrowser\Facades\Mediabrowser;

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

                $this->extension = Filesystem::extension($fullPath);

                $this->folder = $folder;

                $this->back = $back;

                $this->thumb = $this->thumbUrl();
        }

        /**
         * Remove the server private path from the full path of the resource
         * 
         * @param string $path
         * @return string
         */
        private function extractPublicPath($path)
        {
                $rootPath = public_path(Mediabrowser::conf('basepath'));

                $rootNode = Filesystem::pathToArray($rootPath);

                $pathNode = Filesystem::pathToArray($path);

                $diff = array_diff($pathNode, $rootNode);

                $relativePath = array(Mediabrowser::conf('basepath'));

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
                
                $url = (Mediabrowser::conf('imgproxy')) ? $this->imgproxyResizerUrl($resourceUrl, $width, $height) : $resourceUrl;
                
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
                $width = is_null($width) ? Mediabrowser::conf('thumbs.width') : $width;
                
                $height = is_null($height) ? Mediabrowser::conf('thumbs.height') : $height;
                
                $resizePrefix = "packages/spescina/imgproxy/$width/$height/2/70/";
                
                return $resizePrefix . $resourceUrl;
        }

}
