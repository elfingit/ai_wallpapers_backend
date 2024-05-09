<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallpaper\AddRequest;
use App\Http\Resources\Gallery\GalleryResource;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\Wallpaper\Commands\CreateWallpaperCommand;
use Illuminate\Http\Request;

class WallpaperController extends Controller
{
    /**
     * @api {post} /api/v1/wallpaper Generate wallpaper
     * @apiName Generate wallpaper
     * @apiGroup Wallpaper
     * @apiDescription Endpoint for generate wallpaper
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeader {String} Accept application/json
     * @apiHeader {String} X-App-Locale en
     * @apiHeader {String} Authorization Bearer
     *
     * @apiBody {String} prompt picture prompt
     *
     * @apiHeaderExample {String} Header-Example:
     *   {
     *        Accept: application/json
     *        Content-Type: application/json
     *        X-App-Locale: pl
     *        Authorization: Bearer 2|zXp0DMrIjSpyfdbJwO5CCjyn9loYjjcZ5GjZdjHVec126865
     *   }
     *
     * @apiErrorExample {json} Validation-Error:
     *    HTTP/1.1 422
     *    {
     *        "message": "The prompt field is required",
     *        "errors": {
     *          "prompt": [
     *              "The prompt field is required."
     *          ]
     *        }
     *    }
     *
     * @apiErrorExample {json} Forbidden:
     *   HTTP/1.1 403 Forbidden
     *   {
     *       "message": "Forbidden."
     *   }
     *
     * @apiErrorExample {json} Auth-Error:
     *    HTTP/1.1 401
     *    {
     *        message: "Unauthenticated"
     *    }
     *
     * @apiErrorExample {json} Payment Required:
     *     HTTP/1.1 402
     *     {
     *          "message": "Insufficient balance"
     *     }
     *
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 200 OK
     * {
     *      "data": {
     *          "id": 6,
     *          "prompt": "stary samuraj walczy ze śmiercią, obraz w stylu malarstwa japońskiego",
     *          "tags": [
     *              "stary",
     *              "samuraj",
     *              "walczy",
     *              "śmiercią,",
     *              "obraz",
     *              "stylu",
     *              "malarstwa",
     *              "japońskiego"
     *          ],
     *          "thumbnail_url": "http://127.0.0.1:8000/api/v1/gallery/6/thumbnail",
     *          "download_url": "http://127.0.0.1:8000/api/v1/gallery/6/download"
     *      }
     * }
     *
     */
    public function store(AddRequest $request): GalleryResource
    {
        $command = CreateWallpaperCommand::createFromDto($request->getDto(), $request->user());
        $gallery = \CommandBus::dispatch($command);
        \LoggerService::getChannel(LoggerChannel::HTTP_REQUEST)
                      ->info(
                          'Wallpaper created',
                          [
                              'gallery' => $gallery->getResult(),
                              'style' => $request->getDto()->style
                          ]
                      );
        return GalleryResource::make($gallery->getResult());
    }
}
