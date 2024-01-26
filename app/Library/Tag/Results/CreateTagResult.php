<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 04:20
 */

namespace App\Library\Tag\Results;

use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class CreateTagResult implements CommandResultContract
{
    public function __construct(private readonly array $tagIds) {}

    public function getResult(): array
    {
        return $this->tagIds;
    }
}
