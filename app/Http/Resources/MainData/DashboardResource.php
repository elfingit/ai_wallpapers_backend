<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 12.07.24
 * Time: 11:12
 */

namespace App\Http\Resources\MainData;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray($request): array
    {
        $resource = $this->resource;

        return [
            'debt_tokens' => $resource['debt'],
            'debt_money' => $resource['debt'] * 0.07,
            'devices_count' => $resource['devices_count'],
        ];
    }
}
