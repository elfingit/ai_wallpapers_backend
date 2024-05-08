<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.01.24
 * Time: 15:58
 */

namespace App\Http\Requests;

use App\Library\Core\Acl\RulesEnum;
use \Elfin\LaravelDto\Http\Request\AbstractRequest as AbstractDtoRequest;

abstract class AbstractRequest extends AbstractDtoRequest
{
    protected function checkAccess(RulesEnum $rule): bool
    {
        $user = $this->user();
        return $user->tokenCan($rule->value());
    }

}
