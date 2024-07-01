<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 17.04.24
 * Time: 09:23
 */

namespace App\Exceptions;

use App\Models\ApplePurchaseTransaction;

class DuplicateAppleTransactionException extends \Exception
{
    public function __construct(private readonly ApplePurchaseTransaction $transaction)
    {
        $message = "Transaction with id {$transaction->transaction_id} already exists.";
        parent::__construct($message);
    }

    public function getTransaction(): ApplePurchaseTransaction
    {
        return $this->transaction;
    }
}
