<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\AddRequest;
use App\Http\Requests\Gallery\IndexRequest;
use App\Http\Resources\Gallery\GalleryCollection;
use App\Library\Gallery\Commands\CreateGalleryCommand;
use App\Library\Gallery\Commands\IndexGalleryCommand;
use Symfony\Component\HttpFoundation\JsonResponse;

class GalleryController extends Controller
{
    /**
     * @api {post} /api/v1/gallery Add picture
     * @apiName Add picture
     * @apiGroup Gallery
     * @apiDescription Endpoint for add picture
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeader {String} Accept application/json
     * @apiHeader {String} X-App-Locale en
     * @apiHeader {String} Authorization Bearer
     *
     * @apiBody {File} file picture file
     * @apiBody {String} prompt picture prompt
     * @apiBody {String[]} tag array of tags (max 10)
     *
     * @apiHeaderExample {String} Header-Example:
     *  {
     *       Accept: application/json
     *       Content-Type: application/json
     *       X-App-Locale: pl
     *       Authorization: Bearer 2|zXp0DMrIjSpyfdbJwO5CCjyn9loYjjcZ5GjZdjHVec126865
     *  }
     *
     * @apiErrorExample {json} Validation-Error:
     *   HTTP/1.1 422
     *   {
     *       "message": "The file field is required. (and 2 more errors)",
     *       "errors": {
     *               "file": [
     *                   "The file field is required."
     *               ],
     *               "prompt": [
     *                   "The prompt field is required."
     *               ],
     *              "tag": [
     *                  "The tag field is required."
     *             ]
     *       }
     *   }
     *
     * @apiErrorExample {json} Forbidden:
     *  HTTP/1.1 403 Forbidden
     *  {
     *      "message": "Forbidden."
     *  }
     *
     * @apiErrorExample {json} Auth-Error:
     *   HTTP/1.1 401
     *   {
     *       message: "Unauthenticated"
     *   }
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 201 OK
     */
    public function store(AddRequest $request): JsonResponse
    {
        $command = CreateGalleryCommand::createFromDto($request->getDto());
        \CommandBus::dispatch($command);

        return response()->json(status: 201);
    }

    /**
     * @api {get} /api/v1/gallery List of pictures
     * @apiName List of pictures
     * @apiGroup Gallery
     * @apiDescription Endpoint for get list of pictures
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeader {String} Accept application/json
     * @apiHeader {String} X-App-Locale en
     * @apiHeader {String} Authorization Bearer
     *
     * @apiBody {String} [query]
     * @apiBody {Boolean} [public=1]
     *
     * @apiHeaderExample {String} Header-Example:
     *  {
     *       Accept: application/json
     *       Content-Type: application/json
     *       X-App-Locale: pl
     *       Authorization: Bearer 2|zXp0DMrIjSpyfdbJwO5CCjyn9loYjjcZ5GjZdjHVec126865
     *  }
     *
     * @apiErrorExample {json} Validation-Error:
     *   HTTP/1.1 422
     *   {
     *       "message": "The public field must be true or false.",
     *       "errors": {
     *           "public": [ "The public field must be true or false." ]
     *       }
     *   }
     *
     * @apiErrorExample {json} Forbidden:
     *  HTTP/1.1 403 Forbidden
     *  {
     *      "message": "Forbidden."
     *  }
     *
     * @apiErrorExample {json} Auth-Error:
     *   HTTP/1.1 401
     *   {
     *       message: "Unauthenticated"
     *   }
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     * {
     * "data": [{
     *      "id": 1,
     *      "prompt": "tes test test", //Can see admin or owner on his pictures
     *      "tags": [
     *          "castle",
     *          "jungle",
     *          "midjourney"
     *      ],
     *      "thumbnail_url": "http://127.0.0.1:8000/api/v1/gallery/1/thumbnail"
     *  }],
     * "links": {
     *      "first": "http://127.0.0.1:8000/api/v1/gallery?page=1",
     *      "last": "http://127.0.0.1:8000/api/v1/gallery?page=1",
     *      "prev": null,
     *      "next": null
     * },
     * "meta": {
     *      "current_page": 1,
     *      "from": 1,
     *      "last_page": 1,
     *      "links": [{
     *          "url": null,
     *          "label": "&laquo; Previous",
     *          "active": false
     *      },
     *      {
     *          "url": "http://127.0.0.1:8000/api/v1/gallery?page=1",
     *          "label": "1",
     *          "active": true
     *      },
     *      {
     *          "url": null,
     *          "label": "Next &raquo;",
     *          "active": false
     *      }],
     *      "path": "http://127.0.0.1:8000/api/v1/gallery",
     *      "per_page": 15,
     *      "to": 1,
     *      "total": 1
     *  }
     * }
     */
    public function index(IndexRequest $request)
    {
        $command = IndexGalleryCommand::createFromDto($request->getDto(), $request->user()->id);
        $result = \CommandBus::dispatch($command);

        return GalleryCollection::make($result->getResult());
    }
}
