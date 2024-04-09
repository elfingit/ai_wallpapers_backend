<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 9.02.24
 * Time: 09:16
 */

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class ContentPolicyViolationException extends \Exception
{
    private string $form_field;

    public function __construct(
        string $message = "",
        int $code = 0,
        string $form_field = '',
        ?\Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->form_field = $form_field;
    }

    public function getFormField(): string
    {
        return $this->form_field;
    }
}
