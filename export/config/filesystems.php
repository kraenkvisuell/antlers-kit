<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'base' => [
            'driver' => 'local',
            'root' => base_path(),
        ],

        'stubs' => [
            'driver' => 'local',
            'root' => base_path('stubs'),
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => public_path(),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'placeholders' => [
            'driver' => 'local',
            'root' => public_path('placeholders'),
            'url' => '/placeholders',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'logos' => [
            'driver' => 'local',
            'root' => public_path('logos'),
            'url' => '/logos',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'favicons' => [
            'driver' => 'local',
            'root' => public_path('favicons'),
            'url' => '/favicons',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        'assets' => [
            'driver' => 's3',
            'key' => env('CLOUD_ACCESS_KEY_ID'),
            'secret' => env('CLOUD_SECRET_ACCESS_KEY'),
            'region' => env('CLOUD_DEFAULT_REGION'),
            'bucket' => env('CLOUD_BUCKET'),
            'url' => env('CLOUD_URL'),
            'endpoint' => env('CLOUD_ENDPOINT'),
            'use_path_style_endpoint' => env('CLOUD_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'root' => env('CLOUD_ROOT') . '/assets',
            'visibility' => 'public',
        ],

        'attachments' => [
            'driver' => 's3',
            'key' => env('CLOUD_ACCESS_KEY_ID'),
            'secret' => env('CLOUD_SECRET_ACCESS_KEY'),
            'region' => env('CLOUD_DEFAULT_REGION'),
            'bucket' => env('CLOUD_BUCKET'),
            'url' => env('CLOUD_URL'),
            'endpoint' => env('CLOUD_ENDPOINT'),
            'use_path_style_endpoint' => env('CLOUD_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'root' => env('CLOUD_ROOT') . '/attachments',
            'visibility' => 'public',
        ],

        'baseS3' => [
            'driver' => 's3',
            'key' => env('CLOUD_ACCESS_KEY_ID'),
            'secret' => env('CLOUD_SECRET_ACCESS_KEY'),
            'region' => env('CLOUD_DEFAULT_REGION'),
            'bucket' => env('CLOUD_BUCKET'),
            'url' => env('CLOUD_URL'),
            'endpoint' => env('CLOUD_ENDPOINT'),
            'use_path_style_endpoint' => env('CLOUD_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'root' => env('CLOUD_ROOT'),
            'visibility' => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
