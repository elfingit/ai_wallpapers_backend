<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 31.01.24
 * Time: 10:28
 */

namespace App\Library\Core\Contracts\Services;

use App\Library\Core\Logger\LoggerChannel;
use Psr\Log\LoggerInterface;

interface LoggerServiceContract
{
    public function getChannel(LoggerChannel $channel): LoggerInterface;
}
