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
                    'id' => $command->id->value(),
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);

            return null;
        }

        $gallery = Gallery::find($command->id->value());

        if (!$gallery || !is_null($gallery->user_id)) {
            $this->logger->warning('Gallery not found or already has user_id', [
                'extra' => [
                    'id' => $command->id->value(),
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);
            return null;
        }

        //Need wait thumbs and others async tasks
        sleep(5);
        $this->googleService->sendPush();

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }

}
