<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 23.01.24
 * Time: 18:54
 */

namespace App\Facades;

use App\Library\Core\Contracts\AbilitiesProviderContract;
use Illuminate\Support\Facades\Facade;

class AbilityProviderFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AbilitiesProviderContract::class;
    }
}
