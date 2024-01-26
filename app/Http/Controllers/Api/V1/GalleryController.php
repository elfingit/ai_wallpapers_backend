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
     *           "errors": {
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

    public function index(IndexRequest $request)
    {
        $command = IndexGalleryCommand::createFromDto($request->getDto(), $request->user()->id);
        $result = \CommandBus::dispatch($command);

        return GalleryCollection::make($result->getResult());
    }
}
