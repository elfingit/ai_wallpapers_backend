<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 8.05.24
 * Time: 07:30
 */

namespace App\Http\Requests\DeleteAccount;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;

class DeleteRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::DELETE_SELF_ACCOUNT);
    }
    protected function getDtoClass(): ?string
    {
        return null;
    }
}
