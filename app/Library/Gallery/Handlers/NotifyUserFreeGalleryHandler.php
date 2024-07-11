<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 19.04.24
 * Time: 15:44
 */

namespace App\Library\Gallery\Handlers;

use App\GlobalServices\GoogleService;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\Gallery\Commands\NotifyUserFreeGalleryCommand;
use App\Library\Gallery\Commands\PictureUploadedCommand;
use App\Models\Gallery;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Psr\Log\LoggerInterface;

class NotifyUserFreeGalleryHandler implements CommandHandlerContract
{
    private LoggerInterface $logger;
    private GoogleService $googleService;
    public function __construct()
    {
        $this->logger = \LoggerService::getChannel(LoggerChannel::PUSHES);
        $this->googleService = new GoogleService();
    }

    /**
     * @param NotifyUserFreeGalleryCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        if (!\App::isProduction()) {
            $this->logger->info('Service not in production mode, ignore this push', [
                'extra' => [
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);

            return null;
        }

        $this->logger->info('Sending push to user', [
            'extra' => [
                'file' => __FILE__,
                'line' => __LINE__
            ]
        ]);
        $this->googleService->sendPush();

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }

}
