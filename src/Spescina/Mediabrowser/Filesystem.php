<?php namespace Spescina\Mediabrowser;

use Illuminate\Support\Facades\File;

class Filesystem {

        /**
         * Delete the file with the given path
         * 
         * @param string $file
         * @return boolean
         */
        public function fileDelete($file)
        {
                $realPath = public_path($file);

                if ( ! File::isFile($realPath))
                {
                        return false;
                }

                File::delete($realPath);

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

                if ( ! File::isDirectory($realPath))
                {
                        return false;
                }

                File::deleteDirectory($realPath);

                return true;
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
         * Return folders in path
         *
         * @param string $path
         * @return mixed
         */
        public function getFolders($path)
        {
                return File::directories($path);
        }

        /**
         * Return files in path
         *
         * @param string $path
         * @return mixed
         */
        public function getFiles($path)
        {
                return File::files($path);
        }

        /**
         * Check if the given path passes the filesystem validation
         *
         * @param string $path
         * @return boolean
         */
        public function validatePath($path)
        {
                if ( ! File::exists($path))
                {
                        return false;
                }

                if ( ! File::isDirectory($path))
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
                return File::extension($path);
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

}
