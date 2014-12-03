<?php
return array(
        
        /**
         * Use spescina/imageproxy for genarating thumbnails in the browser view
         */
        'imgproxy' => false,
        
        /**
         * if imgproxy === true these settings control thumb dimensions
         */
        'thumbs' => array(
                'width' => 120,
                'height' => 120
        ),
        
        /**
         * Base path of the uploads and browse actions
         */
        'basepath' => 'uploads',
        
        /**
         * Mediabrowser type (Do not override groups, only file extensions)
         */
        'types' => array(
                'image' => array(
                        'jpeg',
                        'jpg',
                        'png',
                        'gif',
                        'bmp'
                ),
                'audio' => array(
                        'mp3',
                        'wav'
                ),
                'video' => array(
                        'mpg',
                        'mpeg',
                        'qt',
                        'mov',
                        'wmv'
                ),
                'doc' => array(
                        'zip',
                        'txt',
                        'doc',
                        'rtf',
                        'docx',
                        'xlsx',
                        'xls',
                        'pdf',
                        'ppt'
                )
        )
);
