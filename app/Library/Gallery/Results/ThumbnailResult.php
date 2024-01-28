<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 28.01.24
 * Time: 04:55
 */

namespace App\Library\Gallery\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class ThumbnailResult implements CommandResultContract
{
    public function __construct(readonly string $path)
    {
    }
    public function getResult(): string
    {
        return $this->path;
    }

}
