<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 11:53
 */

namespace App\Library\Category\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

class MetaCommand extends AbstractCommand
{
    public static function instance(): self
    {
        return new self();
    }
}
