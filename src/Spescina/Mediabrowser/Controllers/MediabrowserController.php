<?php namespace Spescina\Mediabrowser\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Spescina\Mediabrowser\UploadHandler;
use Spescina\Mediabrowser\Facades\Mediabrowser;

class MediabrowserController extends Controller {

        /**
         * Load the library interface
         * 
         * @return Response
         */
        public function index($field, $value = null)
        {
                return View::make('mediabrowser::mediabrowser')
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

                Mediabrowser::browsePath($path, $field);

                $data = Mediabrowser::getItems();

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

                $exec = Mediabrowser::folderCreate($path, $folder);

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

                $exec = Mediabrowser::folderDelete($folder);

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
                
                $allowed = Mediabrowser::allowedExtensions($field);
                
                $options = array(
                    'script_url' => URL::route('mediabrowser.upload') . '/',
                    'upload_dir' => public_path($path) . '/',
                    'upload_url' => asset($path) . '/',
                    'image_versions' => array(),
                    'accept_file_types' => '@(\.|\/)(' . implode('|', $allowed) . ')$@i',
                );
                
                new UploadHandler($options);
        }
        
        /**
         * Handle file deletion
         * 
         * @return Response
         */
        public function fileDelete()
        {
                $file = Input::get('file');

                $exec = Mediabrowser::fileDelete($file);

                return Response::json(array($exec));
        }

}
