<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 10:20
 */

namespace App\Library\PersonalData\Handlers;

use App\Library\Auth\Commands\RemoveUserTokensCommand;
use App\Library\Core\Logger\LoggerChannel;
use App\Library\Gallery\Commands\UserPicturesMakePublicCommand;
use App\Library\PersonalData\Commands\RemoveDataCommand;
use App\Library\UserDevice\Commands\RemoveUserDevicesCommand;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Psr\Log\LoggerInterface;

final class RemoveDataHandler implements CommandHandlerContract
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = \LoggerService::getChannel(LoggerChannel::PERSONAL_DATA);
    }

    /**
     * @param RemoveDataCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $token = base64_decode($command->token->value());

        $user = User::where('remove_data_token', $token)->first();

        if (!$user) {
            $this->logger->warning('User by token not found', [
                'extra' => [
                    'token' => $token,
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);

            return null;
        }

        if (!\Hash::check($user->email . '|' . $user->id, $token)) {
            $this->logger->warning('Invalid token', [
                'extra' => [
                    'token' => $token,
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);

            return null;
        }

        //Make pictures as public
        $commandPicturePublic = UserPicturesMakePublicCommand::instanceFromPrimitive($user->id);
        \CommandBus::dispatch($commandPicturePublic);

        //Delete all users devices
        $commandDeleteDevices = RemoveUserDevicesCommand::instanceFromPrimitive($user->id);
        \CommandBus::dispatch($commandDeleteDevices);

        //Delete all auth tokens
        $commandDeleteTokens = RemoveUserTokensCommand::instanceFromPrimitive($user->id);
        \CommandBus::dispatch($commandDeleteTokens);

        //Delete user record
        $user->delete();

        return null;
    }

    public function isAsync(): bool
    {
        return false;
    }
}
