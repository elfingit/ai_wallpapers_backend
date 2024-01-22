<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.12.23
 * Time: 12:17
 */

use App\Library\Auth\Commands\CreateAuthCommand;
use App\Library\Auth\Handlers\CreateAuthHandler;
use App\Library\Registration\Commands\CreateRegistrationCommand;
use App\Library\Registration\Handlers\CreateRegistrationHandler;
use App\Library\Role\Commands\CreateRoleCommand;
use App\Library\Role\Handlers\CreateRoleHandler;
use App\Library\UserDevice\Commands\CreateUserDeviceCommand;
use App\Library\UserDevice\Commands\GetUserDeviceCommand;
use App\Library\UserDevice\Handlers\CreateUserDeviceHandler;
use App\Library\UserDevice\Handlers\GetUserDeviceHandler;

\CommandBus::addHandler(
    CreateRoleCommand::class,
    CreateRoleHandler::class
);

\CommandBus::addHandler(
    CreateRegistrationCommand::class,
    CreateRegistrationHandler::class
);

\CommandBus::addHandler(
    CreateUserDeviceCommand::class,
    CreateUserDeviceHandler::class
);

\CommandBus::addHandler(
    GetUserDeviceCommand::class,
    GetUserDeviceHandler::class
);

\CommandBus::addHandler(
    CreateAuthCommand::class,
    CreateAuthHandler::class
);
