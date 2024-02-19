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

    public function index(IndexRequest $request): ListCollection
    {
        $command = IndexUserCommand::createFromDto($request->getDto());
        $result = \CommandBus::dispatch($command)->getResult();

        return ListCollection::make($result);
    }
}
