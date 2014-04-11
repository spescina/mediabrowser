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

Route::group(array('prefix' => 'mediabrowser'), function(){
        
        Route::get('{field}/{value?}', array(
                'as' => 'mediabrowser',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MediabrowserController@index'
        ))->where('field', '[A-Za-z0-9-_]+')->where('value', '(.*)');

        Route::post('file_delete', array(
                'as' => 'mediabrowser.fileDelete',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MediabrowserController@fileDelete'
        ));

        Route::post('folder_create', array(
                'as' => 'mediabrowser.folderCreate',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MediabrowserController@folderCreate'
        ));

        Route::post('folder_delete', array(
                'as' => 'mediabrowser.folderDelete',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MediabrowserController@folderDelete'
        ));

        Route::post('browse', array(
                'as' => 'mediabrowser.browse',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\MediabrowserController@browse'
        ));

        Route::post('upload', array(
                'as' => 'mediabrowser.upload',
                'uses' => 'Spescina\\Mediabrowser\\Controllers\\Mediabrowser@filesUpload'
        ));
});
