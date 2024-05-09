<?php

namespace App\Library\Wallpaper\Handlers;

use App\Exceptions\InsufficientBalanceException;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\DeviceBalance\Command\UpdateDeviceBalanceCommand;
use App\Library\Gallery\Commands\CreateGalleryCommand;
use App\Library\Gallery\Commands\GetImageByPromptCommand;
use App\Library\Gallery\Commands\MakePictureCopyCommand;
use App\Library\UserBalance\Commands\GetUserBalanceCommand;
use App\Library\UserBalance\Commands\UpdateUserBalanceCommand;
use App\Library\UserDevice\Commands\GetDeviceBalanceCommand;
use App\Library\Wallpaper\Contracts\ImageGeneratorServiceContract;
use App\Library\Wallpaper\Results\GalleryResult;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

use App\Library\Wallpaper\Commands\CreateWallpaperCommand;
use Psr\Log\LoggerInterface;

class CreateWallpaperHandler implements CommandHandlerContract
{
    private ImageGeneratorServiceContract $aiService;
    private LoggerInterface $logger;

    private bool $use_default_img;

    public function __construct()
    {
        $this->aiService = app(config('ai.current_service'));
        $this->logger = \LoggerService::getChannel(LoggerChannel::WALLPAPER);

        $this->use_default_img = config('ai.use_default_img');
    }

    /**
     * @param CreateWallpaperCommand $command
     * @return CommandResultContract | null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        \DB::beginTransaction();
        try {
            if (!is_null($command->userIdValue)) {
                return $this->createForUser($command);
            } elseif (!is_null($command->deviceIdValue)) {
                return $this->createForDevice($command);
            }
        } catch (InsufficientBalanceException $exception) {
            \DB::rollBack();
            $this->logger->warning('insufficient balance', [
                'prompt'  => $command->promptValue->value(),
                'locale'  => $command->localeValue->value(),
                'user_id' => $command->userIdValue?->value(),
                'device_id' => $command->deviceIdValue?->value(),
                'file'    => __FILE__,
                'line'    => __LINE__
            ]);
            throw $exception;
        } catch (\Throwable $th) {
            \DB::rollBack();
            $this->logger->error('error while trying get an image', [
                'prompt' => $command->promptValue->value(),
                'locale' => $command->localeValue->value(),
                'user_id' => $command->userIdValue?->value(),
                'device_id' => $command->deviceIdValue?->value(),
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'file' => __FILE__,
                'line' => __LINE__
            ]);

            throw $th;
        }

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }

    /*private function processRequestException(RequestException $exception): void
    {
        $data = json_decode($exception->getResponse()->getBody()->getContents(), true);

        if (isset($data['error']) && $data['error']['code'] === 'content_policy_violation') {
            throw new ContentPolicyViolationException(
                form_field: 'prompt',
            );
        }
    }*/

    private function getOwnerBalance(CreateWallpaperCommand $command): float
    {
        $balance = 0.0;

        if (!is_null($command->userIdValue)) {
            $balance = \CommandBus::dispatch(
                GetUserBalanceCommand::instanceFromPrimitives(
                    $command->userIdValue->value()
                )
            )->getResult();
        } else if (!is_null($command->deviceIdValue)) {
            $balance = \CommandBus::dispatch(
                GetDeviceBalanceCommand::instanceFromPrimitive(
                    $command->deviceIdValue->value()
                )
            )->getResult();
        }

        return $balance;
    }

    private function createForUser(CreateWallpaperCommand $command): ?CommandResultContract
    {
        $balance = $this->getOwnerBalance($command);

        if ($balance < 1) {
            throw new InsufficientBalanceException();
        }

        $prompt = $command->promptValue->value();
        $locale = $command->localeValue->value();

        $gallery = null;

        $this->logger->info('trying create wallpaper for user', [
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

            if ($this->use_default_img) {
                \CommandBus::dispatch(
                    UpdateUserBalanceCommand::instanceFromPrimitives(
                        $command->userIdValue->value(),
                        -1,
                        'charge for default wallpaper'
                    )
                );
                \DB::commit();
                return new GalleryResult($gallery);
            }

            if (!is_null($gallery->user_id) && $gallery->user_id != $command->userIdValue->value()) {
                \CommandBus::dispatch(
                    UpdateUserBalanceCommand::instanceFromPrimitives(
                        $gallery->user_id,
                        -1,
                        'charge for wallpaper'
                    )
                );

                $copyCommand = MakePictureCopyCommand::instanceFromPrimitivesWithUser(
                    $gallery->id,
                    $command->userIdValue->value()
                );

                $newGallery = \CommandBus::dispatch($copyCommand)->getResult();

                \DB::commit();

                return new GalleryResult($newGallery);
            }
        }

        $this->logger->info('no matches trying get from AI', [
            'prompt'  => $prompt,
            'locale'  => $locale,
            'user_id' => $command->userIdValue->value(),
            'file'    => __FILE__,
            'line'    => __LINE__
        ]);

        $image_data = $this->aiService->getImageByPrompt($prompt, $command->styleValue->value());

        if ($image_data) {
            $this->logger->info('got it', [
                'prompt'     => $prompt,
                'locale'     => $locale,
                'user_id'    => $command->userIdValue?->value(),
                'device_id'  => $command->deviceIdValue?->value(),
                'image_data' => $image_data,
                'file'       => __FILE__,
                'line'       => __LINE__
            ]);

            $tags = $this->getTags($command);

            $gallery = \CommandBus::dispatch(
                CreateGalleryCommand::createFromPrimitives(
                    $command->promptValue->value(),
                    $tags,
                    $command->localeValue->value(),
                    $image_data['file_path'],
                    user_id: $command->userIdValue->value(),
                    revised_prompt: $image_data['prompt']
                )
            )->getResult();

            \CommandBus::dispatch(
                UpdateUserBalanceCommand::instanceFromPrimitives(
                    $command->userIdValue->value(),
                    -1,
                    'charge for wallpaper'
                )
            );

            \DB::commit();

            return new GalleryResult($gallery);
        }

        \DB::rollBack();
        $this->logger->error('can\'t get AI response', [
            'prompt'  => $prompt,
            'locale'  => $locale,
            'user_id' => $command->userIdValue->value(),
            'file'    => __FILE__,
            'line'    => __LINE__
        ]);

        return null;
    }

    private function getTags(CreateWallpaperCommand $command): array
    {
        $tags = array_filter(
            explode(' ', $command->promptValue->value()),
            fn($tag) => strlen($tag) > 2
        );

        return array_slice($tags, 0, 10);
    }

    private function createForDevice(CreateWallpaperCommand $command): ?CommandResultContract
    {
        $balance = $this->getOwnerBalance($command);

        if ($balance < 1) {
            throw new InsufficientBalanceException();
        }

        $prompt = $command->promptValue->value();
        $locale = $command->localeValue->value();

        $gallery = null;

        $this->logger->info('trying create wallpaper for device', [
            'prompt'  => $prompt,
            'locale'  => $locale,
            'device_id' => $command->deviceIdValue->value(),
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

            if ($this->use_default_img) {
                \CommandBus::dispatch(
                    UpdateDeviceBalanceCommand::instanceFromPrimitives(
                        $command->deviceIdValue->value(),
                        -1,
                        'charge for default wallpaper'
                    )
                );
                \DB::commit();
                return new GalleryResult($gallery, 'need_account_pic');
            }

            if (!is_null($gallery->device_id) && $gallery->device_id != $command->deviceIdValue->value()) {
                \CommandBus::dispatch(
                    UpdateDeviceBalanceCommand::instanceFromPrimitives(
                        $command->deviceIdValue->value(),
                        -1,
                        'charge for wallpaper'
                    )
                );

                $copyCommand = MakePictureCopyCommand::instanceFromPrimitivesWithDevice(
                    $gallery->id,
                    $command->deviceIdValue->value()
                );

                $newGallery = \CommandBus::dispatch($copyCommand)->getResult();

                \DB::commit();

                return new GalleryResult($newGallery, 'need_account_pic');
            }
        }

        $this->logger->info('no matches trying get from AI', [
            'prompt'  => $prompt,
            'locale'  => $locale,
            'user_id' => $command->userIdValue?->value(),
            'device_id' => $command->deviceIdValue?->value(),
            'file'    => __FILE__,
            'line'    => __LINE__
        ]);
        $image_data = $this->aiService->getImageByPrompt($prompt, $command->styleValue->value());

        if ($image_data) {
            $this->logger->info('got it', [
                'prompt'     => $prompt,
                'locale'     => $locale,
                'user_id'    => $command->userIdValue?->value(),
                'device_id'  => $command->deviceIdValue?->value(),
                'image_data' => $image_data,
                'file'       => __FILE__,
                'line'       => __LINE__
            ]);

            $tags = $this->getTags($command);

            $gallery = \CommandBus::dispatch(
                CreateGalleryCommand::createFromPrimitives(
                    $command->promptValue->value(),
                    $tags,
                    $command->localeValue->value(),
                    $image_data['file_path'],
                    device_id: $command->deviceIdValue->value(),
                    revised_prompt: $image_data['prompt']
                )
            )->getResult();

            \CommandBus::dispatch(
                UpdateDeviceBalanceCommand::instanceFromPrimitives(
                    $command->deviceIdValue->value(),
                    -1,
                    'charge for wallpaper'
                )
            );

            \DB::commit();

            return new GalleryResult($gallery, 'need_account_pic');
        } else {
            \DB::rollBack();
            $this->logger->error('can\'t get AI response', [
                'prompt'  => $prompt,
                'locale'  => $locale,
                'device_id' => $command->deviceIdValue->value(),
                'file'    => __FILE__,
                'line'    => __LINE__
            ]);
        }

        return null;
    }
}
