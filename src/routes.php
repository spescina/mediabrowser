<?php
/*
  |--------------------------------------------------------------------------
  | Mediabrowser Routes
  |--------------------------------------------------------------------------
 */

Route::group(array('prefix' => 'mediabrowser'), function(){
        
        $controller = 'Spescina\\Mediabrowser\\Controllers\\MediabrowserController';
        
        Route::get('{field}/{value?}', array(
            'as' => 'mediabrowser',
            'uses' => "$controller@index"
        ))->where('field', '[A-Za-z0-9-_]+')->where('value', '(.*)');

        Route::post('file_delete', array(
                'as' => 'mediabrowser.fileDelete',
                'uses' => "$controller@fileDelete"
        ));

        Route::post('folder_create', array(
                'as' => 'mediabrowser.folderCreate',
                'uses' => "$controller@folderCreate"
        ));

        Route::post('folder_delete', array(
                'as' => 'mediabrowser.folderDelete',
                'uses' => "$controller@folderDelete"
        ));

        Route::post('browse', array(
                'as' => 'mediabrowser.browse',
                'uses' => "$controller@browse"
        ));

        Route::post('upload', array(
                'as' => 'mediabrowser.upload',
                'uses' => "$controller@filesUpload"
        ));
});
