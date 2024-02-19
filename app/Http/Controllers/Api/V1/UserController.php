<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BalanceRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Resources\User\ListCollection;
use App\Library\User\Commands\IndexUserCommand;
use App\Library\UserBalance\Commands\GetUserBalanceCommand;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @api {get} /api/v1/user/balance User balance
     * @apiName User balance
     * @apiGroup User
     * @apiDescription Endpoint for get user balance
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeader {String} Accept application/json
     * @apiHeader {String} X-App-Locale en
     * @apiHeader {String} Authorization Bearer
     *
     * @apiHeaderExample {String} Header-Example:
     *  {
     *       Accept: application/json
     *       Content-Type: application/json
     *       X-App-Locale: pl
     *       Authorization: Bearer 2|zXp0DMrIjSpyfdbJwO5CCjyn9loYjjcZ5GjZdjHVec126865
     *  }
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
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "balance": "5.00"
     *  }
     */
    public function balance(BalanceRequest $request)
    {
        $command = GetUserBalanceCommand::instanceFromPrimitives($request->user()->id);
        $result = \CommandBus::dispatch($command);
        $amount = number_format($result->getResult(), 2);
        return response()->json(['balance' => $amount]);
    }

    /**
     * @api {get} /api/v1/user Users list
     * @apiName Users list
     * @apiGroup User
     * @apiDescription Endpoint for get list of users
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeader {String} Accept application/json
     * @apiHeader {String} X-App-Locale en
     * @apiHeader {String} Authorization Bearer
     *
     * @apiParam {Number} [id] User id - can search partially
     * @apiParam {String} [email] User email - can search partially
     *
     * @apiHeaderExample {String} Header-Example:
     *  {
     *       Accept: application/json
     *       Content-Type: application/json
     *       X-App-Locale: pl
     *       Authorization: Bearer 2|zXp0DMrIjSpyfdbJwO5CCjyn9loYjjcZ5GjZdjHVec126865
     *  }
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
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *
     *  {
     *  "data": [
     *  {
     *      "id": 3,
     *      "email": "test_u1@test.com",
     *      "role": "User",
     *      "balance": "0.00",
     *      "created_at": "2024-01-21 12:33:05"
     *  },
     *  {
     *      "id": 6,
     *      "email": "test_u4@test.com",
     *      "role": "User",
     *      "balance": "0.00",
     *      "created_at": "2024-01-21 12:35:42"
     *  },
     *  {
     *      "id": 7,
     *      "email": "test_u5@test.com",
     *      "role": "User",
     *      "balance": "0.00",
     *      "created_at": "2024-01-22 22:03:58"
     *  }
     *  ],
     *  "links": {
     *      "first": "http://127.0.0.1:8000/api/v1/user?page=1",
     *      "last": "http://127.0.0.1:8000/api/v1/user?page=1",
     *      "prev": null,
     *      "next": null
     *  },
     *  "meta": {
     *      "current_page": 1,
     *      "from": 1,
     *      "last_page": 1,
     *      "links": [
     *      {
     *          "url": null,
     *          "label": "&laquo; Previous",
     *          "active": false
     *      },
     *      {
     *          "url": "http://127.0.0.1:8000/api/v1/user?page=1",
     *          "label": "1",
     *          "active": true
     *      },
     *      {
     *          "url": null,
     *          "label": "Next &raquo;",
     *          "active": false
     *      }
     *      ],
     *      "path": "http://127.0.0.1:8000/api/v1/user",
     *      "per_page": 50,
     *      "to": 8,
     *      "total": 8
     *  }
     * }
     *
     */
    public function index(IndexRequest $request): ListCollection
    {
        $command = IndexUserCommand::createFromDto($request->getDto());
        $result = \CommandBus::dispatch($command)->getResult();

        return ListCollection::make($result);
    }
}
