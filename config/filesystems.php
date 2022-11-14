<?php

declare(strict_types = 1);

$localConfig = [
    'driver' => env('FILE_MANAGER_DRIVER', 'local'),
    'root' => storage_path('app'),
];

$s3Config = [
    'driver' => 's3',
    'root' => storage_path('app'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'key' => env('AWS_ACCESS_KEY_ID'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'visibility' => 'public',
];

$localOrS3 = function (array $merge = []) use ($localConfig, $s3Config): array {
//    if (
//        env('APP_ENV') === 'local' &&
//        filter_var(env('S3_ENABLED_IN_LOCAL'), FILTER_VALIDATE_BOOLEAN) === false
//    ) {
//        return $localConfig;
//    }

    return array_merge($s3Config, $merge);
};

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'gcs' => [
            'driver' => 'gcs',
            'key_file_path' => base_path(). env('GOOGLE_CLOUD_KEY_FILE'), // optional: /path/to/service-account.jso
            'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'), // optional: is included in key file
            'bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET', 'crm-api'),
            'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX', null), // optional: /default/path/to/apply/in/bucket
            'storage_api_uri' => env('GOOGLE_CLOUD_STORAGE_API_URI', 'https://storage.googleapis.com'), // see: Public URLs below
            'visibility' => 'public', // optional: public|private
            'metadata' => ['cacheControl'=> 'public,max-age=86400'], // optional: default metadata
        ],
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        'file_manager' => [
          'driver' => env('FILE_MANAGER_DRIVER', 'local'),
        ],
        'file-uploads' => $localOrS3([
            'version' => 'latest',
        ]),
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        's3-file-uploads' => $localOrS3([
            'version' => 'latest',
        ]),
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
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
