<?php

namespace App\Library\Gallery\Values;

use Illuminate\Http\UploadedFile;

final class FileValue
{
    public function __construct(private readonly UploadedFile $file)
    {
    }

    public function value(): UploadedFile
    {
        return $this->file;
    }
}
