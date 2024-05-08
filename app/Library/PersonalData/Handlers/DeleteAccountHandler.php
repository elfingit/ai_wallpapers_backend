<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 8.05.24
 * Time: 07:36
 */

namespace App\Library\PersonalData\Handlers;

use App\Library\PersonalData\Commands\DeleteAccountCommand;
use App\Library\PersonalData\Commands\RemoveDataCommand;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class DeleteAccountHandler implements CommandHandlerContract
{
    /**
     * @param DeleteAccountCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::findOrFail($command->userId->value());

        $token = \Hash::make($user->email . '|' . $user->id);

        $user->remove_data_token = $token;
        $user->save();

        $removeDataCommand = RemoveDataCommand::instanceFromPrimitive(base64_encode($token));

        return \CommandBus::dispatch($removeDataCommand);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
