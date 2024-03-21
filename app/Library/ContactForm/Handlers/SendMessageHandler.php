<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 21.03.24
 * Time: 07:41
 */

namespace App\Library\ContactForm\Handlers;

use App\Library\ContactForm\Commands\SendMessageCommand;
use App\Library\Core\Logger\LoggerChannel;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class SendMessageHandler implements CommandHandlerContract
{
    private array $config;
    private Client $httpClient;
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->config = config('telegram');
        $this->httpClient = new Client();
        $this->logger = \LoggerService::getChannel(LoggerChannel::TELEGRAM);
    }

    /**
     * @param SendMessageCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $url = $this->buildUrl();
        $body = [
            'chat_id' => $this->config['chat_id'],
            'text' => sprintf(
                "Name: %s\nEmail: %s\nMessage: %s",
                $command->name->value(),
                $command->email->value(),
                $command->message->value()
            ),
            'parse_mode' => 'HTML',
        ];

        try {
            $this->httpClient->post($url, [
                'json' => $body
            ]);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [
                'extra' => [
                    'body' => $body,
                    'file' => __FILE__,
                    'line' => __LINE__,
                    'trace' => $e->getTraceAsString(),
                ]
            ]);
        }

        return null;
    }

    public function isAsync(): bool
    {
        return true;
    }

    private function buildUrl(): string
    {
        return 'https://' . $this->config['api_host'] . '/bot' . $this->config['bot_token'] . '/sendMessage';
    }
}
