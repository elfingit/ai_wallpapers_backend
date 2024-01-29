<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 29.01.24
 * Time: 08:36
 */

namespace App\Library\Gallery\Results;

use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class EditResult implements CommandResultContract
{
    public function __construct(private readonly Gallery $gallery)
    {

    }
    public function getResult(): Gallery
    {
        return $this->gallery;
    }
}
