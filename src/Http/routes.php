<?php
/*
  |--------------------------------------------------------------------------
  | Mediabrowser Routes
  |--------------------------------------------------------------------------
 */

Route::group([
  
  'prefix' => config("mediabrowser.prefix"),
  'middleware' => config("mediabrowser.middleware"),
  'namespace' => 'Spescina\Mediabrowser\Http\Controllers'], function(){
        
        Route::get('{field}/{value?}', array(
            'as' => 'mediabrowser',
            'uses' => "MediabrowserController@index"
        ))->where('field', '[A-Za-z0-9-_]+')->where('value', '(.*)');

        Route::post('file_delete', array(
                'as' => 'mediabrowser.fileDelete',
                'uses' => "MediabrowserController@fileDelete"
        ));

        Route::post('folder_create', array(
                'as' => 'mediabrowser.folderCreate',
                'uses' => "MediabrowserController@folderCreate"
        ));

        Route::post('folder_delete', array(
                'as' => 'mediabrowser.folderDelete',
                'uses' => "MediabrowserController@folderDelete"
        ));

        Route::post('browse', array(
                'as' => 'mediabrowser.browse',
                'uses' => "MediabrowserController@browse"
        ));

        Route::post('upload', array(
                'as' => 'mediabrowser.upload',
                'uses' => "MediabrowserController@filesUpload"
        ));
});
