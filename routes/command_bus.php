<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.12.23
 * Time: 12:17
 */

use App\Library\Registration\Commands\CreateRegistrationCommand;
use App\Library\Registration\Handlers\CreateRegistrationHandler;
use App\Library\Role\Commands\CreateRoleCommand;
use App\Library\Role\Handlers\CreateRoleHandler;

\CommandBus::addHandler(
    CreateRoleCommand::class,
    CreateRoleHandler::class
);

\CommandBus::addHandler(
    CreateRegistrationCommand::class,
    CreateRegistrationHandler::class
);
