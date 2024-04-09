<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.03.24
 * Time: 13:23
 */

namespace App\Library\Auth\Commands;

use App\Library\Auth\Dto\GoogleDto;
use App\Library\Auth\Values\DeviceIdValue;
use App\Library\Auth\Values\EmailValue;
use App\Library\Auth\Values\GoogleIdValue;
use App\Library\Auth\Values\IpValue;
use App\Library\Auth\Values\LocaleValue;
use App\Library\Auth\Values\UserAgentValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class GoogleSignInCommand extends AbstractCommand
{
    public EmailValue $email;
    public GoogleIdValue $id;
    public DeviceIdValue $deviceId;
    public IpValue $ip;
    public UserAgentValue $userAgent;
    public LocaleValue $locale;

    public static function instanceFromDto(GoogleDto $dto): self
    {
        $instance = new self();
        $instance->email = new EmailValue(\Str::lower($dto->email));
        $instance->id = new GoogleIdValue($dto->id);
        $instance->deviceId = new DeviceIdValue($dto->device_id);
        $instance->ip = new IpValue($dto->ip);
        $instance->userAgent = new UserAgentValue($dto->user_agent);
        $instance->locale = new LocaleValue($dto->locale);

        return $instance;
    }
}
