<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 15:06
 */

namespace App\Library\Webhook\Values;

class AppleSignedPayloadValue
{
    public function __construct(readonly private string $payout)
    {
    }

    public function value(): string
    {
        return $this->payout;
    }
}
