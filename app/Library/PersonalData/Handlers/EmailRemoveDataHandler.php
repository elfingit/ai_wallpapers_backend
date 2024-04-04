<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 4.04.24
 * Time: 09:32
 */

namespace App\Library\PersonalData\Handlers;

use App\Library\Core\Logger\LoggerChannel;
use App\Library\PersonalData\Commands\EmailRemoveDataCommand;
use App\Mail\RemovePersonalDataMail;
use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use Psr\Log\LoggerInterface;

class EmailRemoveDataHandler implements CommandHandlerContract
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = \LoggerService::getChannel(LoggerChannel::PERSONAL_DATA);
    }

    /**
     * @param EmailRemoveDataCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $user = User::where('email', $command->emailValue->value())->first();

        if (!$user) {
            $this->logger->warning('User not found', [
                'extra' => [
                    'email' => $command->emailValue->value(),
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);
            return null;
        }

        \App::setLocale($command->localValue->value());
        $token = \Hash::make($user->email . '|' . $user->id);

        $user->remove_data_token = $token;
        $user->save();

        \Mail::to($user->email)->send(new RemovePersonalDataMail($token));

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }
}
