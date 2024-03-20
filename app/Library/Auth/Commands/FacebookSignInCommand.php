<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 20.03.24
 * Time: 13:27
 */

namespace App\Library\Auth\Commands;

use App\Library\Auth\Dto\FacebookDto;
use App\Library\Auth\Values\DeviceIdValue;
use App\Library\Auth\Values\EmailValue;
use App\Library\Auth\Values\FacebookIdValue;
use App\Library\Auth\Values\IpValue;
use App\Library\Auth\Values\LocaleValue;
use App\Library\Auth\Values\UserAgentValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class FacebookSignInCommand extends AbstractCommand
{
    public EmailValue $email;
    public FacebookIdValue $id;
    public DeviceIdValue $deviceId;
    public IpValue $ip;
    public UserAgentValue $userAgent;
    public LocaleValue $locale;

    public static function instanceFromDto(FacebookDto $dto): self
    {
        $instance = new self();
        $instance->email = new EmailValue(\Str::lower($dto->email));
        $instance->id = new FacebookIdValue($dto->id);
        $instance->deviceId = new DeviceIdValue($dto->device_id);
        $instance->ip = new IpValue($dto->ip);
        $instance->userAgent = new UserAgentValue($dto->user_agent);
        $instance->locale = new LocaleValue($dto->locale);
        return $instance;
    }
}
