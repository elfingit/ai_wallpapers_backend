<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof InsufficientBalanceException) {
            return response()->json([
                'message' => __('Insufficient balance'),
            ], 402);
        }

        if ($e instanceof ContentPolicyViolationException) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [
                    $e->getFormField() => [
                        __('Your prompt violate our content policy, please rephrase it.'),
                    ],
                ],
            ], 422);
        }

        return parent::render($request, $e);
    }
}
