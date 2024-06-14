<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 15:10
 */

namespace App\Http\Requests\Webhook;

use App\Http\Requests\AbstractRequest;
use App\Library\Webhook\Dto\AppleDto;

class AppleRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function getDtoClass(): ?string
    {
        return AppleDto::class;
    }
}
