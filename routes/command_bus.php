<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.12.23
 * Time: 12:17
 */

use App\Library\Auth\Commands\CreateAuthCommand;
use App\Library\Auth\Handlers\CreateAuthHandler;
use App\Library\Gallery\Commands\CreateGalleryCommand;
use App\Library\Gallery\Commands\DeleteGalleryCommand;
use App\Library\Gallery\Commands\EditGalleryCommand;
use App\Library\Gallery\Commands\GetImageByPromptCommand;
use App\Library\Gallery\Commands\GetMainFileCommand;
use App\Library\Gallery\Commands\GetThumbnailCommand;
use App\Library\Gallery\Commands\IndexGalleryCommand;
use App\Library\Gallery\Commands\MakePictureCopyCommand;
use App\Library\Gallery\Commands\PictureUploadedCommand;
use App\Library\Gallery\Commands\UpdateGalleryCommand;
use App\Library\Gallery\Handlers\CreateGalleryHandler;
use App\Library\Gallery\Handlers\DeleteGalleryHandler;
use App\Library\Gallery\Handlers\EditGalleryHandler;
use App\Library\Gallery\Handlers\GetImageByPromptHandler;
use App\Library\Gallery\Handlers\GetMailFileHandler;
use App\Library\Gallery\Handlers\GetThumbnailHandler;
use App\Library\Gallery\Handlers\IndexGalleryHandler;
use App\Library\Gallery\Handlers\MakePictureCopyHandler;
use App\Library\Gallery\Handlers\ThumbnailHandler;
use App\Library\Gallery\Handlers\UpdateGalleryHandler;
use App\Library\Registration\Commands\CreateRegistrationCommand;
use App\Library\Registration\Handlers\CreateRegistrationHandler;
use App\Library\Role\Commands\CreateRoleCommand;
use App\Library\Role\Handlers\CreateRoleHandler;
use App\Library\Tag\Commands\CreateTagCommand;
use App\Library\Tag\Handlers\CreateTagHandler;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Library\UserBalance\Handlers\UpdateUserBalanceHandler;
use App\Library\UserDevice\Commands\CreateUserDeviceCommand;
use App\Library\UserDevice\Commands\GetUserDeviceCommand;
use App\Library\UserDevice\Handlers\CreateUserDeviceHandler;
use App\Library\UserDevice\Handlers\GetUserDeviceHandler;
use App\Library\Wallpaper\Commands\CreateWallpaperCommand;
use App\Library\Wallpaper\Handlers\CreateWallpaperHandler;

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

\CommandBus::addHandler(
    CreateGalleryCommand::class,
    CreateGalleryHandler::class
);

\CommandBus::addHandler(
    CreateTagCommand::class,
    CreateTagHandler::class
);

\CommandBus::addHandler(
    IndexGalleryCommand::class,
    IndexGalleryHandler::class
);

\CommandBus::addHandler(
    PictureUploadedCommand::class, [
        ThumbnailHandler::class
    ]
);

\CommandBus::addHandler(
    GetThumbnailCommand::class,
    GetThumbnailHandler::class
);

\CommandBus::addHandler(
    GetMainFileCommand::class,
    GetMailFileHandler::class
);

\CommandBus::addHandler(
    EditGalleryCommand::class,
    EditGalleryHandler::class
);

\CommandBus::addHandler(
    UpdateGalleryCommand::class,
    UpdateGalleryHandler::class
);

\CommandBus::addHandler(
    DeleteGalleryCommand::class,
    DeleteGalleryHandler::class
);

\CommandBus::addHandler(
    CreateWallpaperCommand::class,
    CreateWallpaperHandler::class
);

\CommandBus::addHandler(
    GetImageByPromptCommand::class,
    GetImageByPromptHandler::class
);

\CommandBus::addHandler(
    MakePictureCopyCommand::class,
    MakePictureCopyHandler::class
);

\CommandBus::addHandler(
    UpdateUserBalanceCommand::class,
    UpdateUserBalanceHandler::class
);
