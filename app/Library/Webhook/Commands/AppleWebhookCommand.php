<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 13.06.24
 * Time: 15:06
 */

namespace App\Library\Webhook\Commands;

use App\Library\Webhook\Dto\AppleDto;
use App\Library\Webhook\Values\AppleSignedPayloadValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class AppleWebhookCommand extends AbstractCommand
{
    public AppleSignedPayloadValue $appleSignedPayloadValue;

    public static function instanceFromDto(AppleDto $dto): self
    {
        $instance = new self();
        $instance->appleSignedPayloadValue = new AppleSignedPayloadValue($dto->signedPayload);

        return $instance;
    }
}
