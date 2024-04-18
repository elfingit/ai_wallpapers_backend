<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.04.24
 * Time: 16:14
 */

namespace App\Library\Auth\Commands;

use App\Library\Auth\Dto\AppleDto;
use App\Library\Auth\Values\AppleIdValue;
use App\Library\Auth\Values\DeviceIdValue;
use App\Library\Auth\Values\EmailValue;
use App\Library\Auth\Values\IpValue;
use App\Library\Auth\Values\LocaleValue;
use App\Library\Auth\Values\UserAgentValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class AppleSignInCommand extends AbstractCommand
{
    public ?EmailValue $email = null;
    public AppleIdValue $id;
    public DeviceIdValue $deviceId;
    public IpValue $ip;
    public UserAgentValue $userAgent;
    public LocaleValue $locale;

    public static function instanceFromDto(AppleDto $dto): self
    {
        $instance = new self();
        $instance->email = !is_null($dto->email) ? new EmailValue(\Str::lower($dto->email)) : null;
        $instance->id = new AppleIdValue($dto->id);
        $instance->deviceId = new DeviceIdValue($dto->device_id);
        $instance->ip = new IpValue($dto->ip);
        $instance->userAgent = new UserAgentValue($dto->user_agent);
        $instance->locale = new LocaleValue($dto->locale);

        return $instance;
    }
}
