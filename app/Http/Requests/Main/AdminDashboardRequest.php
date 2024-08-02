<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 12.07.24
 * Time: 10:46
 */

namespace App\Http\Requests\Main;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;

class AdminDashboardRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::ADMIN_DASHBOARD);
    }
    protected function getDtoClass(): ?string
    {
        return null;
    }
}
