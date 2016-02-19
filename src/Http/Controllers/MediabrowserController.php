<?php namespace Spescina\Mediabrowser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Sirius\Upload\Handler as UploadHandler;
use Spescina\Mediabrowser\Facades\Mediabrowser;

class MediabrowserController extends Controller
{

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
     * @param Request $request
     * @return Response
     */
    public function browse(Request $request)
    {
        $path = $request->input('path');

        $field = $request->input('field');

        Mediabrowser::browsePath($path, $field);

        $data = Mediabrowser::getItems();

        return Response::json($data);
    }

    /**
     * Creates a folder at the given path
     *
     * @param Request $request
     * @return Response
     */
    public function folderCreate(Request $request)
    {
        $path = $request->input('path');
        $folder = $request->input('folder');

        $exec = Mediabrowser::folderCreate($path, $folder);

        return Response::json(array($exec));
    }

    /**
     * Delete a folder at the given path
     *
     * @param Request $request
     * @return Response
     */
    public function folderDelete(Request $request)
    {
        $folder = $request->input('folder');

        $exec = Mediabrowser::folderDelete($folder);

        return Response::json(array($exec));
    }

    /**
     * Handle uploaded files
     *
     * @param Request $request
     * @return Response
     */
    public function filesUpload(Request $request)
    {
        $path = $request->input('path');

        $field = $request->input('field');

        $allowed = Mediabrowser::allowedExtensions($field);

        $uploadHandler = new UploadHandler(public_path($path));

        $uploadHandler->addRule('extension', ['allowed' => $allowed]);

        $result = $uploadHandler->process($_FILES['files'], array(
            UploadHandler::OPTION_AUTOCONFIRM => false
        ));

        if ($result->isValid()) {
            $result->confirm();
            return Response::json([]);
        } else {
            $result->clear();
            return Response::json($result->getMessages());
        }
    }

    /**
     * Handle file deletion
     *
     * @param Request $request
     * @return Response
     */
    public function fileDelete(Request $request)
    {
        $file = $request->input('file');

        $exec = Mediabrowser::fileDelete($file);

        return Response::json(array($exec));
    }

}
