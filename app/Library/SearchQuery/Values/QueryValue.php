<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 14.05.24
 * Time: 12:06
 */

namespace App\Library\SearchQuery\Values;

final class QueryValue
{
    public function __construct(private readonly string $query)
    {
    }

    public function value(): string
    {
        return $this->query;
    }
}
