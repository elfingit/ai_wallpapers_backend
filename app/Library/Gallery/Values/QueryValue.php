<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.01.24
 * Time: 11:26
 */

namespace App\Library\Gallery\Values;

final class QueryValue
{
    public function __construct(private readonly string $query) {}

    public function value(): string
    {
        return $this->query;
    }
}
