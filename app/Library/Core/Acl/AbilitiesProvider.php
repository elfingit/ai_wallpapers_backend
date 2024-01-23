<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 23.01.24
 * Time: 18:47
 */

namespace App\Library\Core\Acl;

use App\Library\Core\Contracts\AbilitiesProviderContract;

class AbilitiesProvider implements AbilitiesProviderContract
{
    public function getAbilitiesForRole(string $role): array
    {
        return config('abilities.' . $role, []);
    }
}
