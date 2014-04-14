<?php

use Illuminate\Support\Facades\Config as IlluminateConfig;
use Illuminate\Support\Facades\Session;
use Mockery as m;
use Spescina\Mediabrowser\Browser;
use Spescina\PkgSupport\Config;
use Spescina\PkgSupport\Lang;

class BrowserTest extends PHPUnit_Framework_TestCase {
        
        private $browser;
        
        private $types = array(
                'image' => array('jpeg'),
                'audio' => array('mp3', 'wav' ),
                'video' => array('mpg'),
                'doc' => array('zip')
        );
        
        public function setUp()
        {
                $this->browser = new Browser(new Config('mediabrowser'), new Lang('mediabrowser'));
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
                
                $extensions = $this->browser->allowedExtensions('media');
                
                $this->assertEquals(array('mp3','wav'), $extensions);
        }
}
