<?php

use Illuminate\Support\Facades\URL;
use Mockery as m;
use Spescina\Mediabrowser\Facades\Filesystem;
use Spescina\Mediabrowser\Facades\Mediabrowser;
use Spescina\Mediabrowser\Item;

class ItemTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function test_other_file_instantiate()
    {
        Filesystem::shouldReceive('extractName')
            ->once()
            ->with('foo/bar.txt')
            ->andReturn('bar.txt');

        Filesystem::shouldReceive('extension')
            ->once()
            ->with('foo/bar.txt')
            ->andReturn('txt');

        URL::shouldReceive('asset')
            ->once()
            ->with('packages/spescina/mediabrowser/img/icons/txt.png')
            ->andReturn('http://www.example.com/packages/spescina/mediabrowser/img/icons/txt.png');

        $item = new Item('foo/bar.txt');

        $this->assertEquals('foo/bar.txt', $item->path);
        $this->assertEquals('bar.txt', $item->name);
        $this->assertEquals('txt', $item->extension);
        $this->assertFalse($item->folder);
        $this->assertFalse($item->back);
        $this->assertEquals('http://www.example.com/packages/spescina/mediabrowser/img/icons/txt.png', $item->thumb);
    }

    public function test_folder_instantiate()
    {
        Filesystem::shouldReceive('extractName')
            ->once()
            ->with('foo')
            ->andReturn('foo');

        Filesystem::shouldReceive('extension')
            ->once()
            ->with('foo');

        URL::shouldReceive('asset')
            ->once()
            ->with('packages/spescina/mediabrowser/img/icons/folder.png')
            ->andReturn('http://www.example.com/packages/spescina/mediabrowser/img/icons/folder.png');

        $item = new Item('foo', true);

        $this->assertEquals('foo', $item->path);
        $this->assertEquals('foo', $item->name);
        $this->assertTrue($item->folder);
        $this->assertFalse($item->back);
        $this->assertEquals('http://www.example.com/packages/spescina/mediabrowser/img/icons/folder.png', $item->thumb);
    }

    public function test_back_folder_instantiate()
    {
        Filesystem::shouldReceive('extractName')
            ->once()
            ->with('foo')
            ->andReturn('foo');

        Filesystem::shouldReceive('extension')
            ->once()
            ->with('foo');

        URL::shouldReceive('asset')
            ->once()
            ->with('packages/spescina/mediabrowser/img/icons/back.png')
            ->andReturn('http://www.example.com/packages/spescina/mediabrowser/img/icons/back.png');

        $item = new Item('foo', true, true);

        $this->assertEquals('foo', $item->path);
        $this->assertEquals('..', $item->name);
        $this->assertTrue($item->folder);
        $this->assertTrue($item->back);
        $this->assertEquals('http://www.example.com/packages/spescina/mediabrowser/img/icons/back.png', $item->thumb);
    }

    public function test_image_thumb_url()
    {
        Filesystem::shouldReceive('extractName')
            ->once()
            ->with('foo/bar.jpg')
            ->andReturn('bar.jpg');

        Filesystem::shouldReceive('extension')
            ->once()
            ->with('foo/bar.jpg')
            ->andReturn('jpg');

        URL::shouldReceive('asset')
            ->once()
            ->with('foo/bar.jpg')
            ->andReturn('http://www.example.com/foo/bar.jpg');

        $item = new Item('foo/bar.jpg');

        $this->assertEquals('http://www.example.com/foo/bar.jpg', $item->thumb);
    }
}
