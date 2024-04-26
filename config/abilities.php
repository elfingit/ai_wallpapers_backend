<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 23.01.24
 * Time: 18:48
 */
return [
    'admin' => require_once 'abilities/admin.php',
    'user' => require_once 'abilities/user.php',
    'paiduser' => require_once 'abilities/paiduser.php',
    'device' => require_once 'abilities/device.php'
];
