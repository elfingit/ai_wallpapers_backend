<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 24.01.24
 * Time: 15:18
 */

namespace App\Library\Core\Acl;

enum RulesEnum : string
{
    case ADD_FILE_TO_GALLERY = 'add:gallery';

    public function value(): string
    {
        return $this->value;
    }
}
