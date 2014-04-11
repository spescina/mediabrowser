<?php
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::group(array('prefix' => 'medialibrary'), function(){
        
        Route::get('{field}/{value?}', array(
                'as' => 'medialibrary',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MedialibraryController@index'
        ))->where('field', '[A-Za-z0-9-_]+')->where('value', '(.*)');

        Route::post('file_delete', array(
                'as' => 'medialibrary.fileDelete',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MedialibraryController@fileDelete'
        ));

        Route::post('folder_create', array(
                'as' => 'medialibrary.folderCreate',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MedialibraryController@folderCreate'
        ));

        Route::post('folder_delete', array(
                'as' => 'medialibrary.folderDelete',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MedialibraryController@folderDelete'
        ));

        Route::post('browse', array(
                'as' => 'medialibrary.browse',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MedialibraryController@browse'
        ));

        Route::post('upload', array(
                'as' => 'medialibrary.upload',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MedialibraryController@filesUpload'
        ));
});
