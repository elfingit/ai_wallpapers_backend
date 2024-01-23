<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AddRequest;
use App\Library\Auth\Commands\CreateAuthCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @api {post} /api/v1/auth Auth
     * @apiName Auth
     * @apiGroup Auth
     * @apiDescription Endpoint for authentication
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeader {String} Accept application/json
     *
     * @apiBody {String} email User email
     * @apiBody {String} password User password
     * @apiBody {String} device_id Device id
     *
     * @apiHeaderExample {String} Header-Example:
     *  {
     *       Accept: application/json
     *       Content-Type: application/json
     *  }
     *
     * @apiErrorExample {json} Validation-Error:
     *   HTTP/1.1 422
     *   {
     *       "message": "The email field is required. (and 2 more errors)",
     *       "errors": {
     *           "errors": {
     *               "email": [
     *                   "The email field is required."
     *               ],
     *               "password": [
     *                   "The password field is required."
     *               ],
     *              "device_id": [
     *                  "The device id field is required."
     *             ]
     *       }
     *   }
     *
     * @apiErrorExample {json} Auth-Error:
     *  HTTP/1.1 401 Unauthorized
     *  {
     *      "message": "Invalid credentials."
     *  }
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "token": "2|zXp0DMrIjSpyfdbJwO5CCjyn9loYjjcZ5GjZdjHVec126865",
     *      "role": "user"
     *  }
     */
    public function store(AddRequest $request): JsonResponse
    {
        $command = CreateAuthCommand::createFromDto(
            $request->getDto(),
            $request->ip(),
            $request->userAgent()
        );
        $result = \CommandBus::dispatch($command);

        return response()->json($result->getResult());
    }
}
