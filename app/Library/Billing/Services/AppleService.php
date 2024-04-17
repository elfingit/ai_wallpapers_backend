<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 16.04.24
 * Time: 15:44
 */

namespace App\Library\Billing\Services;

use App\Library\Billing\Services\Apple\AppleEnvironment;
use App\Library\Billing\Services\Apple\JwtTokenGenerator;
use App\Library\Core\Logger\LoggerChannel;
use GuzzleHttp\Client;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\Plain;
use Psr\Log\LoggerInterface;

class AppleService
{
    const PROD_URL = 'https://api.storekit.itunes.apple.com/inApps/v1/transactions/%s';
    const SANDBOX_URL = 'https://api.storekit-sandbox.itunes.apple.com/inApps/v1/transactions/%s';

    private JwtTokenGenerator $jwtTokenGenerator;
    private AppleEnvironment $environment;

    private LoggerInterface $logger;

    private Client $httpClient;

    public function __construct()
    {
        $this->jwtTokenGenerator = new JwtTokenGenerator(
            config('apple.key_id'),
            config('apple.issuer_id'),
            config('apple.bundle_id'),
            config('apple.file_path_private_key')
        );

        $this->environment = AppleEnvironment::tryFrom(config('apple.environment'));

        $this->logger = \LoggerService::getChannel(LoggerChannel::APPLE_PURCHASE);
        $this->httpClient = new Client();
    }

    public function getPurchase(string $transaction_id): ?Plain
    {
        $token = $this->getToken();
        return $this->loadData($transaction_id, $token);
    }

    private function getToken(): string
    {
        $this->logger->info('trying to get access token', [
            'extra' => [
                'file' => __FILE__,
                'line' => __LINE__
            ]
        ]);
        $token = \Cache::get('apple_access_token');

        if ($token) {
            $this->logger->info('found in cache', [
                'extra' => [
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);
            return $token;
        }

        $token = $this->jwtTokenGenerator->generate();

        \Cache::put('apple_access_token', $token, 29);

        return $token;
    }

    private function loadData(string $transaction_id, string $token): ?Plain
    {
        $url = match ($this->environment) {
            AppleEnvironment::PRODUCTION => sprintf(self::PROD_URL, $transaction_id),
            AppleEnvironment::SANDBOX => sprintf(self::SANDBOX_URL, $transaction_id),
        };

        try {
            $response = $this->httpClient->get($url,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json'
                    ]
                ]
            );

            $data = json_decode(
                $response->getBody()->getContents(),
                true,
                flags: JSON_THROW_ON_ERROR
            );

            if (!isset($data['signedTransactionInfo'])) {
                return null;
            }

            $parser = new Parser(new JoseEncoder());
            return $parser->parse($data['signedTransactionInfo']);

        } catch (\Exception $e) {
            $this->logger->error('error while loading data', [
                'extra' => [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);

            return null;
        }
    }
}
