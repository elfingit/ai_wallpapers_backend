<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 31.01.24
 * Time: 14:06
 */

namespace App\Library\Gallery\Values;

class FilePathValue
{
    public function __construct(private readonly string $file_path)
    {
    }

    public function value(): string
    {
        return $this->file_path;
    }
}
