<?php
return [

    /**
     * Use spescina/imageproxy for genarating thumbnails in the browser view
     */
    'imgproxy' => false,

    /**
     * if imgproxy === true these settings control thumb dimensions
     */
    'thumbs' => [
        'width' => 120,
        'height' => 120
    ],

    /**
     * Base path of the uploads and browse actions
     */
    'basepath' => 'uploads',

    /**
     * Mediabrowser type (Do not override groups, only file extensions)
     */
    'types' => [
        'image' => [
            'jpeg',
            'jpg',
            'png',
            'gif',
            'bmp'
        ],
        'audio' => [
            'mp3',
            'wav'
        ],
        'video' => [
            'mpg',
            'mpeg',
            'qt',
            'mov',
            'wmv'
        ],
        'doc' => [
            'zip',
            'txt',
            'doc',
            'rtf',
            'docx',
            'xlsx',
            'xls',
            'pdf',
            'ppt'
        ]
    ]
];
