<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Intervention Image Driver
    |--------------------------------------------------------------------------
    |
    | Supported: "gd", "imagick", "gmagick"
    |
    */

    'driver' => 'gd',


    /*
    |--------------------------------------------------------------------------
    | Intervention Image Driver Settings
    |--------------------------------------------------------------------------
    |
    | Depending on the used driver you can add settings here. Take a look
    | at the official documentation for possible settings.
    |
    */

    'drivers' => [
        'imagick' => [
            'library_path' => '/opt/local/bin',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Path
    |--------------------------------------------------------------------------
    |
    | The path to the publicly accessible directory.
    |
    */

    'public_path' => public_path(),

];
