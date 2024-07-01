<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 15:14
 */

namespace App\Http\Requests\Main;

use App\Http\Requests\AbstractRequest;
use App\Library\Category\Dto\MainDto;
use App\Library\Core\Acl\RulesEnum;

class IndexRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return $this->checkAccess(RulesEnum::MAIN_INDEX);
    }
    protected function getDtoClass(): ?string
    {
        return MainDto::class;
    }
}
