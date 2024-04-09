<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 23.01.24
 * Time: 18:43
 */

namespace App\Library\Core\Contracts;

interface AbilitiesProviderContract
{
    public function getAbilitiesForRole(string $role): array;
}
