<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Mockery as m;
use org\bovigo\vfs\vfsStream;
use Spescina\Mediabrowser\Filesystem;

class FilesystemTest extends PHPUnit_Framework_TestCase
{

    private $fs;

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

        $this->fs = new Filesystem(vfsStream::url('root'));
    }

    public function tearDown()
    {
        m::close();
    }

    public function test_instantiate()
    {
        App::shouldReceive('make')
            ->with('path.public')
            ->andReturn('/var/www/uploads');

        $fs = new Filesystem();

        $this->assertEquals('/var/www/uploads', $fs->root);
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

        $delete = $this->fs->fileDelete('foo.txt');

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

        $this->fs->fileDelete('txt.txt');
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

        $delete = $this->fs->folderDelete('folder');

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

        $this->fs->folderDelete('bad_folder');
    }

    public function test_folder_create()
    {
        File::shouldReceive('makeDirectory')
            ->once()
            ->with('vfs://root/folder/new_folder')
            ->andReturn(true);

        $create = $this->fs->folderCreate('folder', 'new_folder');

        $this->assertTrue($create);
    }

    public function test_get_folders()
    {
        File::shouldReceive('directories')
            ->once()
            ->with('vfs://root/folder')
            ->andReturn(array('folder_1', 'folder_2'));

        $folders = $this->fs->getFolders('folder');

        $this->assertEquals(array('folder_1', 'folder_2'), $folders);
    }

    public function test_get_files()
    {
        File::shouldReceive('files')
            ->once()
            ->with('vfs://root/folder')
            ->andReturn(array('bar.txt'));

        $files = $this->fs->getFiles('folder');

        $this->assertEquals(array('bar.txt'), $files);
    }

    public function test_extension()
    {
        File::shouldReceive('extension')
            ->once()
            ->with('vfs://root/foo.txt')
            ->andReturn('txt');

        $ext = $this->fs->extension('foo.txt');

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

        $check = $this->fs->validatePath('foo.txt');

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

        $check = $this->fs->validatePath('folder');

        $this->assertTrue($check);
    }

    public function test_array_to_path()
    {
        $path = $this->fs->arrayToPath(array('my', 'folder', 'path'));

        $this->assertEquals('my/folder/path', $path);
    }

    public function test_path_to_array()
    {
        $array = $this->fs->pathToArray('my/folder/path');

        $this->assertEquals(array('my', 'folder', 'path'), $array);
    }

    public function test_extract_name()
    {
        $name = $this->fs->extractName('my/folder/path');

        $this->assertEquals('path', $name);
    }

    public function test_get_path()
    {
        $path = $this->fs->getPath('uploads');

        $this->assertEquals('vfs://root/uploads', $path);
    }

}
