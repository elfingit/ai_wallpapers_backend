<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 3.02.24
 * Time: 18:27
 */

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;

class LogoutRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::LOGOUT);
    }
    protected function getDtoClass(): ?string
    {
        return null;
    }
}
