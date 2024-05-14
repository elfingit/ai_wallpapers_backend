<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 14.05.24
 * Time: 12:05
 */

namespace App\Library\SearchQuery\Commands;

use App\Library\SearchQuery\Values\DeviceIdValue;
use App\Library\SearchQuery\Values\QueryValue;
use Elfin\LaravelCommandBus\Library\AbstractCommand;

class QueryToWallpaperCommand extends AbstractCommand
{
    public QueryValue $query;
    public DeviceIdValue $deviceId;

    static public function instanceFromPrimitives(string $query, string $device_id): self
    {
        $command = new self();
        $command->query = new QueryValue($query);
        $command->deviceId = new DeviceIdValue($device_id);

        return $command;
    }
}
