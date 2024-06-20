<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.06.24
 * Time: 10:27
 */

namespace App\Http\Requests\Main;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;

class ProfileRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::MAIN_PROFILE);
    }
    protected function getDtoClass(): ?string
    {
        return null;
    }
}
