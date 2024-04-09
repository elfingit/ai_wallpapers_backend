<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 31.01.24
 * Time: 10:27
 */

namespace App\Library\Core\Services;

use App\Library\Core\Contracts\Services\LoggerServiceContract;
use App\Library\Core\Logger\LoggerChannel;
use Psr\Log\LoggerInterface;

class LoggerService implements LoggerServiceContract
{
    public function getChannel(LoggerChannel $channel): LoggerInterface
    {
        return \Log::channel($channel->value);
    }
}
