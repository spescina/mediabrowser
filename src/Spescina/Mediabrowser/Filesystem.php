<?php namespace Spescina\Mediabrowser;

use Illuminate\Support\Facades\File;
use Spescina\Mediabrowser\Exceptions\DirectoryDoesNotExists;
use Spescina\Mediabrowser\Exceptions\FileDoesNotExists;

class Filesystem {

        private $root;

        public function __construct($root = null)
        {
                $this->root = $root ? : public_path();
        }

        /**
         * Delete the file with the given path
         * 
         * @param string $file
         * @return boolean
         * @throws Spescina\Mediabrowser\Exceptions\FileDoesNotExists
         */
        public function fileDelete($file)
        {
                if ( ! File::isFile($this->getPath($file)))
                {
                        throw new FileDoesNotExists;
                }

                return File::delete($this->getPath($file));
        }

        /**
         * Delete the folder with the given path
         * 
         * @param string $folder
         * @return boolean
         * @throws Spescina\Mediabrowser\Exceptions\DirectoryDoesNotExists
         */
        public function folderDelete($folder)
        {
                if ( ! File::isDirectory($this->getPath($folder)))
                {
                        throw new DirectoryDoesNotExists;
                }

                return File::deleteDirectory($this->getPath($folder));
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
                return File::makeDirectory($this->getPath($path . '/' . $folder));;
        }

        /**
         * Return folders in path
         *
         * @param string $path
         * @return mixed
         */
        public function getFolders($path)
        {
                return File::directories($this->getPath($path));
        }

        /**
         * Return files in path
         *
         * @param string $path
         * @return mixed
         */
        public function getFiles($path)
        {
                return File::files($this->getPath($path));
        }

        /**
         * Check if the given path passes the filesystem validation
         *
         * @param string $path
         * @return boolean
         */
        public function validatePath($path)
        {
                if ( ! File::exists($this->getPath($path)))
                {
                        return false;
                }

                if ( ! File::isDirectory($this->getPath($path)))
                {
                        return false;
                }

                return true;
        }

        /**
         * Return the type of the resource
         * 
         * @param string $path
         */
        public function extension($path)
        {
                return File::extension($this->getPath($path));
        }

        /**
         * Convert given path in an array of segments
         *
         * @param string path
         * @returns array
         */
        public function pathToArray($path)
        {
                return explode('/', $path);
        }

        /**
         * Convert given array of segments in a path
         *
         * @param array segments
         * @returns string
         */
        public function arrayToPath($segments)
        {
                return implode('/', $segments);
        }
        
        /**
         * Return only the file|folder name
         * 
         * @param string $path
         * @return string
         */
        public function extractName($path)
        {
                $segments = $this->pathToArray($path);

                return array_pop($segments);
        }

        private function getPath($piece)
        {
                return $this->root . '/' . $piece;
        }

}
