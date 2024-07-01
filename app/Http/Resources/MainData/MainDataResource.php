<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 15:54
 */

namespace App\Http\Resources\MainData;

use App\Http\Resources\Gallery\GalleryCollection;
use App\Http\Resources\Gallery\GalleryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MainDataResource extends JsonResource
{
    public function toArray($request): array
    {
        $data = [];

        foreach ($this->resource as $item) {
            $data[] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'pictures' => GalleryCollection::make($item['pictures']),
            ];
        }

        return $data;
    }
}
