<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'success' => $this->resource['success'],
            'amount' => $this->resource['amount']
        ];

        if (isset($this->resource['warn_code'])) {
            $data['warn_code'] = $this->resource['warn_code'];
        }

        return $data;
    }
}
