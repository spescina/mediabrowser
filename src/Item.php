<?php namespace Spescina\Mediabrowser;

use Illuminate\Support\Facades\URL;
use Spescina\Mediabrowser\Facades\Filesystem as FsFacade;

class Item
{

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
    public $thumb;

    /**
     * Setup of the resource
     *
     * @param string $path
     * @param bool $folder
     */
    public function __construct($path, $folder = false, $back = false)
    {
        $this->path = $path;

        $this->name = ($folder && $back) ? '..' : FsFacade::extractName($path);

        $this->extension = FsFacade::extension($path);

        $this->folder = $folder;

        $this->back = $folder && $back;

        $this->thumb = $this->thumbUrl();
    }

    /**
     * Return the link to the resource icon
     *
     * @return string
     */
    private function thumb()
    {
        $preview = ['png', 'jpg', 'gif', 'bmp'];

        $publicBaseUrl = 'packages/spescina/mediabrowser/img/icons/';

        if ($this->folder) {
            if ($this->back) {
                $icon = 'back';
            } else {
                $icon = 'folder';
            }

            $url = $publicBaseUrl . $icon . '.png';
        } else {
            if (in_array($this->extension, $preview)) {
                $url = $this->path;
            } else {
                $url = $publicBaseUrl . $this->extension . '.png';
            }
        }

        return $url;
    }

    /**
     * Return the item url
     *
     * @return string
     */
    public function thumbUrl()
    {
        $resourceUrl = $this->thumb();

        return URL::asset($resourceUrl);
    }

}
