<?php

use Illuminate\Support\Facades\File;
use org\bovigo\vfs\vfsStream;
use Mockery as m;
use Spescina\Mediabrowser\Filesystem;

class FilesystemTest extends PHPUnit_Framework_TestCase {

        public function setUp()
        {
                $fs = array(
                    'foo.txt' => 'foo bar',
                    'folder' => array(
                        'folder_1' => array(),
                        'folder_2' => array(),
                        'bar.txt' => 'bar foo'
                    )
                );
                
                vfsStream::setup('root', null, $fs);
        }
        
        public function tearDown()
        {
                m::close();
        }
        
        public function test_file_delete()
        {
                File::shouldReceive('isFile')
                        ->once()
                        ->with('vfs://root/foo.txt')
                        ->andReturn(true);
                
                File::shouldReceive('delete')
                        ->once()
                        ->with('vfs://root/foo.txt')
                        ->andReturn(true);
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $delete = $fs->fileDelete('foo.txt');
                
                $this->assertTrue($delete);
        }
        
        /**
         * @expectedException Spescina\Mediabrowser\Exceptions\FileDoesNotExists
         */
        public function test_fail_file_delete()
        {
                File::shouldReceive('isFile')
                        ->once()
                        ->with('vfs://root/txt.txt')
                        ->andReturn(false);
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $fs->fileDelete('txt.txt');
        }
        
        public function test_folder_delete()
        {
                File::shouldReceive('isDirectory')
                        ->once()
                        ->with('vfs://root/folder')
                        ->andReturn(true);
                
                File::shouldReceive('deleteDirectory')
                        ->once()
                        ->with('vfs://root/folder')
                        ->andReturn(true);
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $delete = $fs->folderDelete('folder');
                
                $this->assertTrue($delete);
        }
        
        /**
         * @expectedException Spescina\Mediabrowser\Exceptions\DirectoryDoesNotExists
         */
        public function test_fail_folder_delete()
        {
                File::shouldReceive('isDirectory')
                        ->once()
                        ->with('vfs://root/bad_folder')
                        ->andReturn(false);
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $fs->folderDelete('bad_folder');
        }
        
        public function test_folder_create()
        {
                File::shouldReceive('makeDirectory')
                        ->once()
                        ->with('vfs://root/folder/new_folder')
                        ->andReturn(true);
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $create = $fs->folderCreate('folder', 'new_folder');
                
                $this->assertTrue($create);
        }
        
        public function test_get_folders()
        {
                File::shouldReceive('directories')
                        ->once()
                        ->with('vfs://root/folder')
                        ->andReturn(array('folder_1', 'folder_2'));
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $folders = $fs->getFolders('folder');
                
                $this->assertEquals(array('folder_1', 'folder_2'), $folders);
        }
        
        public function test_get_files()
        {
                File::shouldReceive('files')
                        ->once()
                        ->with('vfs://root/folder')
                        ->andReturn(array('bar.txt'));
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $files = $fs->getFiles('folder');
                
                $this->assertEquals(array('bar.txt'), $files);
        }
        
        public function test_extension()
        {
                File::shouldReceive('extension')
                        ->once()
                        ->with('vfs://root/foo.txt')
                        ->andReturn('txt');
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $ext = $fs->extension('foo.txt');
                
                $this->assertEquals('txt', $ext);
        }
        
        public function test_fail_validate_folder_path()
        {
                File::shouldReceive('exists')
                        ->once()
                        ->with('vfs://root/foo.txt')
                        ->andReturn(true);
                
                File::shouldReceive('isDirectory')
                        ->once()
                        ->with('vfs://root/foo.txt')
                        ->andReturn(false);
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $check = $fs->validatePath('foo.txt');
                
                $this->assertFalse($check);
        }
        
        public function test_validate_folder_path()
        {
                File::shouldReceive('exists')
                        ->once()
                        ->with('vfs://root/folder')
                        ->andReturn(true);
                
                File::shouldReceive('isDirectory')
                        ->once()
                        ->with('vfs://root/folder')
                        ->andReturn(true);
                
                $fs = new Filesystem(vfsStream::url('root'));
                
                $check = $fs->validatePath('folder');
                
                $this->assertTrue($check);
        }
        
        public function test_array_to_path()
        {
                $fs = new Filesystem(vfsStream::url('root'));
                
                $path = $fs->arrayToPath(array('my', 'folder', 'path'));
                
                $this->assertEquals('my/folder/path', $path);
        }
        
        public function test_path_to_array()
        {
                $fs = new Filesystem(vfsStream::url('root'));
                
                $array = $fs->pathToArray('my/folder/path');
                
                $this->assertEquals(array('my', 'folder', 'path'), $array);
        }

}
