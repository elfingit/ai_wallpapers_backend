<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 16.04.24
 * Time: 16:21
 */
return [
    'environment' => env('APPLE_ENVIRONMENT', 'sandbox'),
    'key_id' => env('APPLE_KEY_ID'),
    'issuer_id' => env('APPLE_ISSUER_ID'),
    'bundle_id' => env('APPLE_BUNDLE_ID', 'com.nuntechs.aiwallpaper'),
    'file_path_private_key' => base_path('/data_files/apple.key'),
];
