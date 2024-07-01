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
    #[ValidationRule('required|string|max:150|in:weekly_5_tokens,monthly_20_tokens,yearly_80_tokens')]
    public string $product_id;

    #[RequestParam('purchase_token')]
    #[ValidationRule('required|string|max:255')]
    public string $purchase_token;

    public ?int $user_id = null;

    public ?string $device_id = null;
    public int $product_amount;
}
