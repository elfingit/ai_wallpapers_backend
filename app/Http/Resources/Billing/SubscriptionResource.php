<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 18.06.24
 * Time: 14:27
 */

namespace App\Http\Resources\Billing;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "success" => $this->resource['success'],
            "amount" => $this->resource['amount'],
            "subscription_end_date" => $this->resource['subscription_end_date'],
        ];
    }
}
