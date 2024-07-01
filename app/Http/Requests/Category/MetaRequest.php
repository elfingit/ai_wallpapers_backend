<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 11:51
 */

namespace App\Http\Requests\Category;

use App\Http\Requests\AbstractRequest;
use App\Library\Core\Acl\RulesEnum;

class MetaRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::META_CATEGORY);
    }

    protected function getDtoClass(): ?string
    {
        return null;
    }
}
