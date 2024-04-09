<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 31.01.24
 * Time: 11:22
 */

namespace App\Facades;

use App\Library\Core\Contracts\Services\LoggerServiceContract;
use Illuminate\Support\Facades\Facade;

class LoggerServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return LoggerServiceContract::class;
    }
}
