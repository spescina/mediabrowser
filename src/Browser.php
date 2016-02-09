<?php namespace Spescina\Mediabrowser;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Spescina\Mediabrowser\Facades\Filesystem as FsFacade;

class Browser
{
    /**
     * Items in the current path
     *
     * @var array
     */
    private $items = array();

    /**
     * Form field name linked to the browser
     *
     * @var string
     */
    private $field;

    /**
     * Current browsed path
     *
     * @var string
     */
    private $path;

    const TYPE_ALL = 'all';
    const TYPE_AUDIO = 'audio';
    const TYPE_DOC = 'doc';
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    /**
     * Return objects in the given path
     *
     * @param string $path
     * @param string $field
     * @return boolean
     */
    public function browsePath($path, $field)
    {
        if (!FsFacade::validatePath($path)) {
            return false;
        }

        $this->path = $path;

        $this->field = $field;

        $this->folders();

        $this->files();
    }

    /**
     * Return the local config var in json notation
     * embeddable as a javascript config object
     *
     * @return string
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
        foreach ($items as $item) {
            $this->addItem(new Item($item, true));
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
        foreach ($items as $item) {
            $extension = FsFacade::extension($item);

            if ($this->allowed($extension, $field)) {
                $this->addItem(new Item($item));
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

        if (!$this->isRoot()) {
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
        if (in_array($extension, $this->allowedExtensions($field))) {
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
        if ($this->path === $this->conf('basepath')) {
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
        if ($this->isRoot()) {
            return $this->conf('basepath');
        }

        $segments = FsFacade::pathToArray($this->path);

        array_pop($segments);

        return FsFacade::arrayToPath($segments);
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

        if ($mediabrowserType === self::TYPE_ALL) {
            return $this->allAllowedExtensions();
        }

        $types = $this->conf('types');

        if (!isset($types[$mediabrowserType])) {
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
    public function allowedExtensionsToJSON($field)
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

        if (!isset($fields[$field]['allowed'])) {
            throw new \Exception('No media fields defined.');
        }

        return $fields[$field]['allowed'];
    }

    /**
     * Return all allowed defined extensions
     *
     * @return array
     */
    private function allAllowedExtensions()
    {
        $extensions = array();

        foreach ($this->conf('types') as $ext) {
            $extensions = array_merge($extensions, $ext);
        }

        return $extensions;
    }

    /**
     * Return the current path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Add folders to the item list
     */
    private function folders()
    {
        $folders = FsFacade::getFolders($this->path);

        $this->parseFolders($folders);
    }

    /**
     * Add files to the item list
     */
    private function files()
    {
        $files = FsFacade::getFiles($this->path);

        $this->parseFiles($files, $this->field);
    }

    /**
     * Add one item to the item list
     *
     * @param \Spescina\Mediabrowser\Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * Delete a file from the server
     *
     * @param string $file
     * @return boolean
     */
    public function fileDelete($file)
    {
        return FsFacade::fileDelete($file);
    }

    /**
     * Delete a folder from the server
     *
     * @param string $folder
     * @return boolean
     */
    public function folderDelete($folder)
    {
        return FsFacade::folderDelete($folder);
    }

    /**
     * Create a folder on the server
     *
     * @param string $path
     * @param string $folder
     * @return boolean
     */
    public function folderCreate($path, $folder)
    {
        return FsFacade::folderCreate($path, $folder);
    }

    public function lang($key)
    {
        return Lang::trans("mediabrowser::mediabrowser.$key");
    }

    public function conf($key = null)
    {
        return $key ? Config::get("mediabrowser.$key") : Config::get('mediabrowser');
    }

}
