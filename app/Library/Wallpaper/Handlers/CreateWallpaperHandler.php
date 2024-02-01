<?php

namespace App\Library\Wallpaper\Handlers;

use App\Exceptions\InsufficientBalanceException;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\Gallery\Commands\CreateGalleryCommand;
use App\Library\Gallery\Commands\GetImageByPromptCommand;
use App\Library\Gallery\Commands\MakePictureCopyCommand;
use App\Library\Gallery\Handlers\CreateGalleryHandler;
use App\Library\UserBalance\Commands\GetUserBalanceCommand;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Library\Wallpaper\Infrastructure\DalleService;
use App\Library\Wallpaper\Results\GalleryResult;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Wallpaper\Commands\CreateWallpaperCommand;
use Psr\Log\LoggerInterface;

class CreateWallpaperHandler implements CommandHandlerContract
{
    private DalleService $dalleService;
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->dalleService = new DalleService();
        $this->logger = \LoggerService::getChannel(LoggerChannel::OPEN_AI);
    }

    /**
     * @param CreateWallpaperCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        \DB::beginTransaction();

        $prompt = $command->promptValue->value();
        $locale = $command->localeValue->value();

        try {
            $balance = \CommandBus::dispatch(
                GetUserBalanceCommand::instanceFromPrimitives(
                    $command->userIdValue->value()
                )
            )->getResult();

            if ($balance < 1) {
                throw new InsufficientBalanceException();
            }

            $gallery = null;

            $this->logger->info('trying create wallpaper', [
                'prompt'  => $prompt,
                'locale'  => $locale,
                'user_id' => $command->userIdValue->value(),
                'file'    => __FILE__,
                'line'    => __LINE__
            ]);

            $galleryResponse = \CommandBus::dispatch(
                GetImageByPromptCommand::instanceFromPrimitives(
                    $prompt,
                    $locale
                )
            );

            if ($galleryResponse) {
                $gallery = $galleryResponse->getResult();
            }

            if ($gallery) {
                $this->logger->info('matched with prompt', [
                    'prompt'  => $prompt,
                    'locale'  => $locale,
                    'g_id'    => $gallery->id,
                    'user_id' => $command->userIdValue->value(),
                    'file'    => __FILE__,
                    'line'    => __LINE__
                ]);


                $newGallery = \CommandBus::dispatch(
                    MakePictureCopyCommand::instanceFromPrimitives(
                        $gallery->id,
                        $command->userIdValue->value()
                    )
                )->getResult();
                
                if ($gallery->user_id != $command->userIdValue->value()) {
                    \CommandBus::dispatch(UpdateUserBalanceCommand::instanceFromPrimitives(
                        $gallery->user_id,
                        -1,
                        'reward for wallpaper'
                    ));
                }
                \DB::commit();

                return new GalleryResult($newGallery);
            }

            $this->logger->info('no matches trying get from AI', [
                'prompt'  => $prompt,
                'locale'  => $locale,
                'user_id' => $command->userIdValue->value(),
                'file'    => __FILE__,
                'line'    => __LINE__
            ]);
            $image_data = $this->dalleService->getImageByPrompt($prompt);

            if ($image_data) {
                $this->logger->info('got it', [
                    'prompt'     => $prompt,
                    'locale'     => $locale,
                    'user_id'    => $command->userIdValue->value(),
                    'image_data' => $image_data,
                    'file'       => __FILE__,
                    'line'       => __LINE__
                ]);

                $tags = array_filter(
                    explode(' ', $command->promptValue->value()),
                    fn($tag) => strlen($tag) > 2
                );

                $tags = array_slice($tags, 0, 10);

                $gallery = \CommandBus::dispatch(
                    CreateGalleryCommand::createFromPrimitives(
                        $command->promptValue->value(),
                        $tags,
                        $command->localeValue->value(),
                        $command->userIdValue->value(),
                        $image_data['file_path']
                    )
                )->getResult();

                \CommandBus::dispatch(UpdateUserBalanceCommand::instanceFromPrimitives(
                    $command->userIdValue->value(),
                    -1,
                    'charge for wallpaper'
                ));
                \DB::commit();
                return new GalleryResult($gallery);
            } else {
                \DB::rollBack();
                $this->logger->error('can\'t get AI response', [
                    'prompt'  => $prompt,
                    'locale'  => $locale,
                    'user_id' => $command->userIdValue->value(),
                    'file'    => __FILE__,
                    'line'    => __LINE__
                ]);
            }
        } catch (InsufficientBalanceException $exception) {
            \DB::rollBack();
            $this->logger->error('insufficient balance', [
                'prompt'  => $prompt,
                'locale'  => $locale,
                'user_id' => $command->userIdValue->value(),
                'file'    => __FILE__,
                'line'    => __LINE__
            ]);
            throw $exception;
        } catch (\Throwable $th) {
            \DB::rollBack();
            $this->logger->error('error while trying get an image', [
                'prompt' => $prompt,
                'locale' => $locale,
                'user_id' => $command->userIdValue->value(),
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'file' => __FILE__,
                'line' => __LINE__
            ]);
        }

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
