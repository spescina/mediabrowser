<?php

use Illuminate\Support\Facades\Config as IlluminateConfig;
use Illuminate\Support\Facades\Session;
use Mockery as m;
use Spescina\Mediabrowser\Browser;

class BrowserTest extends PHPUnit_Framework_TestCase
{

    private $browser;

    private $types = array(
        'image' => array('jpeg'),
        'audio' => array('mp3', 'wav'),
        'video' => array('mpg'),
        'doc' => array('zip')
    );

    public function setUp()
    {
        $this->browser = new Browser();
    }

    public function tearDown()
    {
        m::close();
    }

    public function test_all_allowed_extensions()
    {
        Session::shouldReceive('get')
            ->once()
            ->with('formFields')
            ->andReturn(array(
                'media' => array(
                    'type' => 'media',
                    'allowed' => Browser::TYPE_ALL
                )
            ));

        IlluminateConfig::shouldReceive('get')
            ->once()
            ->andReturn($this->types);

        $extensions = $this->browser->allowedExtensions('media');

        $this->assertEquals(array('jpeg', 'mp3', 'wav', 'mpg', 'zip'), $extensions);
    }

    public function test_allowed_extensions()
    {
        Session::shouldReceive('get')
            ->once()
            ->with('formFields')
            ->andReturn(array(
                'media' => array(
                    'type' => 'media',
                    'allowed' => Browser::TYPE_AUDIO
                )
            ));

        IlluminateConfig::shouldReceive('get')
            ->once()
            ->andReturn($this->types);

        $extensions = $this->browser->allowedExtensions('media');

        $this->assertEquals(array('mp3', 'wav'), $extensions);
    }

    /**
     * @expectedException Exception
     */
    public function test_extensions_group_not_available()
    {
        Session::shouldReceive('get')
            ->once()
            ->with('formFields')
            ->andReturn(array(
                'media' => array(
                    'type' => 'media',
                    'allowed' => 'foo'
                )
            ));

        $this->browser->allowedExtensions('media');
    }

    public function test_config_to_json()
    {
        IlluminateConfig::shouldReceive('get')
            ->once()
            ->andReturn(array(
                'foo' => 'a',
                'bar' => 'b'
            ));

        $json = $this->browser->configToJSON();

        $this->assertEquals('{"foo":"a","bar":"b"}', $json);
    }

    public function test_allowed_extensions_to_json()
    {
        Session::shouldReceive('get')
            ->once()
            ->with('formFields')
            ->andReturn(array(
                'media' => array(
                    'type' => 'media',
                    'allowed' => Browser::TYPE_AUDIO
                )
            ));

        $json = $this->browser->allowedExtensionsToJSON('media');

        $this->assertEquals('["mp3","wav"]', $json);
    }

    /*public function test_add_item()
    {
        FsFacade::shouldReceive('extractName')
            ->once()
            ->with('foo/bar.txt')
            ->andReturn('bar.txt');

        FsFacade::shouldReceive('extension')
            ->once()
            ->with('foo/bar.txt')
            ->andReturn('txt');

        Mediabrowser::shouldReceive('conf')
            ->once()
            ->with('imgproxy')
            ->andReturn(false);

        URL::shouldReceive('asset')
            ->once()
            ->with('packages/spescina/mediabrowser/src/img/icons/txt.png')
            ->andReturn('http://www.example.com/packages/spescina/mediabrowser/src/img/icons/txt.png');

        FsFacade::shouldReceive('pathToArray')
            ->once()
            ->andReturn(array('path'));

        FsFacade::shouldReceive('arrayToPath')
            ->once()
            ->andReturn(array());

        $item = new Item('foo/bar.txt');

        $this->assertEmpty($this->browser->getItems());

        $this->browser->addItem($item);

        $this->assertContains($item, $this->browser->getItems());
    }

    public function test_browse_path()
    {
        Filesystem::shouldReceive('validatePath')
            ->once()
            ->with('uploads')
            ->andReturn(true);

        Filesystem::shouldReceive('getFolders')
            ->once()
            ->with('uploads')
            ->andReturn(array('foo', 'bar'));

        $this->browser->browsePath('uploads', 'media');

        $path = $this->browser->getPath();

        $this->assertEquals('uploads', $path);
    }*/
}
