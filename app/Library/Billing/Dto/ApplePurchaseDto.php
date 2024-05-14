<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 16.04.24
 * Time: 14:58
 */

namespace App\Library\Billing\Dto;

use Elfin\LaravelDto\Dto\Attributes\RequestParam;
use Elfin\LaravelDto\Dto\Attributes\ValidationRule;

class ApplePurchaseDto
{
    #[RequestParam('product_id')]
    #[ValidationRule('required|string|max:150|in:ai_requests_2,ai_requests_5,ai_requests_10,ai_requests_20')]
    public string $product_id;

    #[RequestParam('purchase_token')]
    #[ValidationRule('required|string|max:255')]
    public string $purchase_token;

    public ?int $user_id = null;

    public ?string $device_id = null;
    public int $product_amount;
}
