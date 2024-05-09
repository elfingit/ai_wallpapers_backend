<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 30.01.24
 * Time: 09:53
 */

namespace App\Library\Wallpaper\Results;

use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GalleryResult implements CommandResultContract
{
    public function __construct(private readonly Gallery $gallery, private readonly ?string $warn_code = null)
    {
    }

    public function getResult(): array
    {
        return [
            'gallery' => $this->gallery,
            'warn_code' => $this->warn_code
        ];
    }
}
