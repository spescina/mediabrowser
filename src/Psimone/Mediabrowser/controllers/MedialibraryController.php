<?php namespace Psimone\Mediabrowser\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Psimone\Mediabrowser\Classes\UploadHandler;
use Psimone\Mediabrowser\Facades\MediaLibrary;

class MedialibraryController extends Controller {

        /**
         * Load the library interface
         * 
         * @return Response
         */
        public function index($field, $value = null)
        {
                return View::make('mediabrowser::medialibrary')
                                ->with('field', $field)
                                ->with('value', $value);
        }

        /**
         * Return the list of all resources at the given path
         * 
         * @return Response
         */
        public function browse()
        {
                $path = Input::get('path');
                
                $field = Input::get('field');

                MediaLibrary::browsePath($path, $field);

                $data = MediaLibrary::getItems();

                return Response::json($data);
        }
        
        /**
         * Creates a folder at the given path
         * 
         * @return Response
         */
        public function folderCreate()
        {
                $path = Input::get('path');
                $folder = Input::get('folder');

                $exec = MediaLibrary::folderCreate($path, $folder);

                return Response::json(array($exec));
        }
        
        /**
         * Delete a folder at the given path
         * 
         * @return Response
         */
        public function folderDelete()
        {
                $folder = Input::get('folder');

                $exec = MediaLibrary::folderDelete($folder);

                return Response::json(array($exec));
        }
        
        /**
         * Handle uploaded files
         * 
         * @return Response
         */
        public function filesUpload()
        {
                $path = Input::get('path');
                
                $field = Input::get('field');
                
                $allowed = MediaLibrary::allowedExtensions($field);
                
                $options = array(
                    'script_url' => URL::route('medialibrary.upload') . '/',
                    'upload_dir' => public_path($path) . '/',
                    'upload_url' => asset($path) . '/',
                    'image_versions' => array(),
                    'accept_file_types' => '@(\.|\/)(' . implode('|', $allowed) . ')$@i',
                );
                
                $upload_handler = new UploadHandler($options);
        }
        
        /**
         * Handle file deletion
         * 
         * @return Response
         */
        public function fileDelete()
        {
                $file = Input::get('file');

                $exec = MediaLibrary::fileDelete($file);

                return Response::json(array($exec));
        }

}
