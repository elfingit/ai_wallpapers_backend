<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 12.04.24
 * Time: 10:32
 */
return [
    'use_default_img' => env('AI_USE_DEFAULT_IMG', false),
    'default_img' => env('AI_DEFAULT_IMG_ID', 0),
    'current_service' => env('AI_CURRENT_SERVICE', 'dall-e'),
];
