<?php

use Illuminate\Support\Facades\URL;
use Mockery as m;
use Spescina\Mediabrowser\Facades\Filesystem;
use Spescina\Mediabrowser\Facades\Mediabrowser;
use Spescina\Mediabrowser\Item;

class ItemTest extends PHPUnit_Framework_TestCase {
        
        public function tearDown()
        {
                m::close();
        }
        
        public function test_file_instantiate()
        {
                Filesystem::shouldReceive('extractName')
                        ->once()
                        ->with('foo/bar.txt')
                        ->andReturn('bar.txt');
                
                Filesystem::shouldReceive('extension')
                        ->once()
                        ->with('foo/bar.txt')
                        ->andReturn('txt');
                
                Mediabrowser::shouldReceive('conf')
                        ->once()
                        ->with('imgproxy');
                
                URL::shouldReceive('asset')
                        ->once();
                
                $item = new Item('foo/bar.txt');
                
                $this->assertEquals('foo/bar.txt', $item->path);
                $this->assertEquals('bar.txt', $item->name);
                $this->assertEquals('txt', $item->extension);
                $this->assertFalse($item->folder);
                $this->assertFalse($item->back);
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
                
                Mediabrowser::shouldReceive('conf')
                        ->once()
                        ->with('imgproxy');
                
                URL::shouldReceive('asset')
                        ->once();
                
                $item = new Item('foo', true);
                
                $this->assertEquals('foo', $item->path);
                $this->assertEquals('foo', $item->name);
                $this->assertTrue($item->folder);
                $this->assertFalse($item->back);
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
                
                Mediabrowser::shouldReceive('conf')
                        ->once()
                        ->with('imgproxy');
                
                URL::shouldReceive('asset')
                        ->once();
                
                $item = new Item('foo', true, true);
                
                $this->assertEquals('foo', $item->path);
                $this->assertEquals('..', $item->name);
                $this->assertTrue($item->folder);
                $this->assertTrue($item->back);
        }
        
        public function test_fail_back_file_instantiate()
        {
                Filesystem::shouldReceive('extractName')
                        ->once()
                        ->with('foo')
                        ->andReturn('foo');
                
                Filesystem::shouldReceive('extension')
                        ->once()
                        ->with('foo');
                
                Mediabrowser::shouldReceive('conf')
                        ->once()
                        ->with('imgproxy');
                
                URL::shouldReceive('asset')
                        ->once();
                
                $item = new Item('foo', false, true);
                
                $this->assertEquals('foo', $item->path);
                $this->assertEquals('foo', $item->name);
                $this->assertFalse($item->folder);
                $this->assertFalse($item->back);
        }
}
