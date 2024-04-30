<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.12.23
 * Time: 12:17
 */

use App\Library\Auth\Commands\AppleSignInCommand;
use App\Library\Auth\Commands\CreateAuthCommand;
use App\Library\Auth\Commands\FacebookSignInCommand;
use App\Library\Auth\Commands\GoogleSignInCommand;
use App\Library\Auth\Commands\LogoutCommand;
use App\Library\Auth\Commands\RemoveUserTokensCommand;
use App\Library\Auth\Handlers\AppleSignInHandler;
use App\Library\Auth\Handlers\CreateAuthHandler;
use App\Library\Auth\Handlers\FacebookSignInHandler;
use App\Library\Auth\Handlers\GoogleSignInHandler;
use App\Library\Auth\Handlers\LogoutHandler;
use App\Library\Auth\Handlers\RemoveUserTokensHandler;
use App\Library\Billing\Commands\ApplePurchaseCommand;
use App\Library\Billing\Commands\ApplePurchaseTransactionCommand;
use App\Library\Billing\Commands\GooglePurchaseCommand;
use App\Library\Billing\Commands\GooglePurchaseTransactionCommand;
use App\Library\Billing\Handlers\ApplePurchaseHandler;
use App\Library\Billing\Handlers\ApplePurchaseTransactionHandler;
use App\Library\Billing\Handlers\GooglePurchaseHandler;
use App\Library\Billing\Handlers\GooglePurchaseTransactionHandler;
use App\Library\ContactForm\Commands\SendMessageCommand;
use App\Library\ContactForm\Handlers\SendMessageHandler;
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Library\DeviceBalance\Handlers\UpdateDeviceBalanceHandler;
use App\Library\DeviceToken\Commands\CreateDeviceTokenCommand;
use App\Library\DeviceToken\Handlers\CreateDeviceTokenHandler;
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
use App\Library\Gallery\Commands\UserPicturesMakePublicCommand;
use App\Library\Gallery\Handlers\CreateGalleryHandler;
use App\Library\Gallery\Handlers\DeleteGalleryHandler;
use App\Library\Gallery\Handlers\EditGalleryHandler;
use App\Library\Gallery\Handlers\GalleryReplicateHandler;
use App\Library\Gallery\Handlers\GetImageByPromptHandler;
use App\Library\Gallery\Handlers\GetMailFileHandler;
use App\Library\Gallery\Handlers\GetThumbnailHandler;
use App\Library\Gallery\Handlers\IndexGalleryHandler;
use App\Library\Gallery\Handlers\MakePictureCopyHandler;
use App\Library\Gallery\Handlers\NotifyUserFreeGalleryHandler;
use App\Library\Gallery\Handlers\ThumbnailHandler;
use App\Library\Gallery\Handlers\UpdateGalleryHandler;
use App\Library\Gallery\Handlers\UserPicturesMakePublicHandler;
use App\Library\PersonalData\Commands\EmailRemoveDataCommand;
use App\Library\PersonalData\Commands\RemoveDataCommand;
use App\Library\PersonalData\Handlers\EmailRemoveDataHandler;
use App\Library\PersonalData\Handlers\RemoveDataHandler;
use App\Library\Registration\Commands\CreateRegistrationCommand;
use App\Library\Registration\Handlers\CreateRegistrationHandler;
use App\Library\Role\Commands\CreateRoleCommand;
use App\Library\Role\Handlers\CreateRoleHandler;
use App\Library\Tag\Commands\CreateTagCommand;
use App\Library\Tag\Handlers\CreateTagHandler;
use App\Library\User\Commands\IndexUserCommand;
use App\Library\User\Commands\UserRegisteredCommand;
use App\Library\User\Commands\UserRegisteredFromSocialNetworkCommand;
use App\Library\User\Handlers\IndexUserHandler;
use App\Library\User\Handlers\UserRegisteredFromSocialNetworkHandler;
use App\Library\User\Handlers\WelcomeMailHandler;
use App\Library\UserBalance\Commands\GetUserBalanceCommand;
use App\Library\UserBalance\Commands\RemoveUserBalanceCommand;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Library\UserBalance\Handlers\GetUserBalanceHandler;
use App\Library\UserBalance\Handlers\GiftForBalanceHandler;
use App\Library\UserBalance\Handlers\RemoveUserBalanceHandler;
use App\Library\UserBalance\Handlers\UpdateUserBalanceHandler;
use App\Library\UserBalanceTransaction\Commands\CreateUserBalanceTransactionCommand;
use App\Library\UserBalanceTransaction\Handlers\CreateUserBalanceTransactionHandler;
use App\Library\UserDevice\Commands\CreateUserDeviceCommand;
use App\Library\UserDevice\Commands\GetDeviceBalanceCommand;
use App\Library\UserDevice\Commands\GetUserDeviceCommand;
use App\Library\UserDevice\Commands\RemoveUserDevicesCommand;
use App\Library\UserDevice\Handlers\CreateUserDeviceHandler;
use App\Library\UserDevice\Handlers\GetDeviceBalanceHandler;
use App\Library\UserDevice\Handlers\GetUserDeviceHandler;
use App\Library\UserDevice\Handlers\RemoveUserDevicesHandler;
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
        ThumbnailHandler::class,
        GalleryReplicateHandler::class,
        NotifyUserFreeGalleryHandler::class
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

\CommandBus::addHandler(
    CreateUserBalanceTransactionCommand::class,
    CreateUserBalanceTransactionHandler::class
);

\CommandBus::addHandler(
    GetUserBalanceCommand::class,
    GetUserBalanceHandler::class
);

\CommandBus::addHandler(
    LogoutCommand::class,
    LogoutHandler::class
);

\CommandBus::addHandler(
    IndexUserCommand::class,
    IndexUserHandler::class
);

\CommandBus::addHandler(
    UserRegisteredCommand::class,[
        WelcomeMailHandler::class,
        GiftForBalanceHandler::class
    ]
);

\CommandBus::addHandler(
    FacebookSignInCommand::class,
    FacebookSignInHandler::class
);

\CommandBus::addHandler(
    GoogleSignInCommand::class,
    GoogleSignInHandler::class
);

\CommandBus::addHandler(
    AppleSignInCommand::class,
    AppleSignInHandler::class
);

\CommandBus::addHandler(
    UserRegisteredFromSocialNetworkCommand::class, [
        UserRegisteredFromSocialNetworkHandler::class,
        GiftForBalanceHandler::class
    ]
);

\CommandBus::addHandler(
    SendMessageCommand::class,
    SendMessageHandler::class
);

\CommandBus::addHandler(
    RemoveDataCommand::class,
    RemoveDataHandler::class
);

\CommandBus::addHandler(
    EmailRemoveDataCommand::class,
    EmailRemoveDataHandler::class
);

\CommandBus::addHandler(
    UserPicturesMakePublicCommand::class,
    UserPicturesMakePublicHandler::class
);

\CommandBus::addHandler(
    RemoveUserDevicesCommand::class,
    RemoveUserDevicesHandler::class
);

\CommandBus::addHandler(
    RemoveUserTokensCommand::class,
    RemoveUserTokensHandler::class
);

\CommandBus::addHandler(
    RemoveUserBalanceCommand::class,
    RemoveUserBalanceHandler::class
);

\CommandBus::addHandler(
    GooglePurchaseCommand::class,
    GooglePurchaseHandler::class
);

\CommandBus::addHandler(
    GooglePurchaseTransactionCommand::class,
    GooglePurchaseTransactionHandler::class
);

\CommandBus::addHandler(
    ApplePurchaseCommand::class,
    ApplePurchaseHandler::class
);

\CommandBus::addHandler(
    ApplePurchaseTransactionCommand::class,
    ApplePurchaseTransactionHandler::class
);

\CommandBus::addHandler(
    CreateDeviceTokenCommand::class,
    CreateDeviceTokenHandler::class
);

\CommandBus::addHandler(
    GetDeviceBalanceCommand::class,
    GetDeviceBalanceHandler::class
);


\CommandBus::addHandler(
    UpdateDeviceBalanceCommand::class,
    UpdateDeviceBalanceHandler::class
);
